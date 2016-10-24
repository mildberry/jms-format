<?php

namespace Mildberry\JMSFormat\Parser;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMText;
use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSAbstractContentBlock;
use Mildberry\JMSFormat\Block\JMSBlockquoteBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSHeadlineBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSParagraphBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\Block\JMSVideoBlock;
use Mildberry\JMSFormat\Exception\BadBlockNameException;
use Mildberry\JMSFormat\Interfaces\ParserInterface;
use Mildberry\JMSFormat\JMSAttributeHelper;
use Mildberry\JMSFormat\JMSModifierHelper;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class HtmlParser implements ParserInterface
{
    const ROOT_NODE_ID = 'DOMRootBodyElement';

    const ALLOWED_TAGS = '<p><span><b><i><del><u><blockquote><h1><h2><h3><h4><img><object>';

    /**
     * @param string $content
     * @return JMSCollectionBlock
     */
    public function toCollection($content)
    {
        return $this->createCollectionFormHtml($content);
    }

    /**
     * @param JMSCollectionBlock $collection
     * @return string
     */
    public function toContent(JMSCollectionBlock $collection)
    {
        return $this->getContentFromCollection($collection);
    }

    /**
     * @param string $content
     * @return JMSCollectionBlock
     */
    private function createCollectionFormHtml($content)
    {
        return $this->createCollectionByDOMElements($this->createDOMElementsByHtml($content));
    }

    /**
     * @param string $content
     * @return DOMNodeList
     */
    private function createDOMElementsByHtml($content)
    {
        $DOMDocument = new DOMDocument('1.0', 'UTF-8');
        $DOMDocument->loadHTML('<?xml version="1.0" encoding="UTF-8"?><body id="'.self::ROOT_NODE_ID.'">'.strip_tags($content, self::ALLOWED_TAGS).'</body>');

        return $DOMDocument->getElementById(self::ROOT_NODE_ID)->childNodes;
    }

    /**
     * @param DOMNodeList $elements
     * @param array $modifiers
     * @return JMSCollectionBlock
     */
    public function createCollectionByDOMElements(DOMNodeList $elements, $modifiers = [])
    {
        $collection = new JMSCollectionBlock();

        foreach ($elements as $element) {
            // as text has no tags
            if ($element instanceof DOMText) {
                if ($text = strip_tags($element->nodeValue)) {
                    $block = (new JMSTextBlock($text));
                    JMSModifierHelper::setBlockModifiers($block, $modifiers);
                    $collection->addBlock($block);
                }
            } elseif ($element instanceof DOMElement) {
                $block = $this->createBlockFromDOMElement($element, $modifiers);
                if ($element->hasChildNodes()) {
                    if ($block instanceof JMSCollectionBlock) {
                        $block->addCollection($this->createCollectionByDOMElements($element->childNodes));
                        $collection->addBlock($block);
                    } else {
                        $collection->addCollection($this->createCollectionByDOMElements($element->childNodes, JMSModifierHelper::getBlockModifiers($block)));
                    }
                } else {
                    $collection->addBlock($block);
                }
            }
        }

        return $collection;
    }

    /**
     * @param DOMElement $element
     * @param array $parentModifiers
     * @return JMSAbstractBlock
     */
    private function createBlockFromDOMElement($element, $parentModifiers = [])
    {
        $tagName = mb_strtolower($element->tagName);

        $block = $this->createBlock($tagName,  strip_tags($element->nodeValue));

        $attributesMap = $this->getAttributesMap();
        $allowedModifiers = JMSModifierHelper::getAllowedModifiers();
        $allowedAttributes = JMSAttributeHelper::getAllowedAttributes();

        foreach ($element->attributes as $nodeAttribute) {
            $attributeName = (!empty($attributesMap[$nodeAttribute->name])) ? $attributesMap[$nodeAttribute->name] : $nodeAttribute->name;
            if ($attributeName == 'class') {
                foreach (explode(' ', $nodeAttribute->nodeValue) as $class) {
                    list($modifier, $value) = array_pad(explode('-', $class), 2, '');

                    if (in_array($modifier, $allowedModifiers) && $modifier && $value) {
                        $modifierClassName = JMSModifierHelper::getModifierInterfaceClassName($modifier);
                        if ($block instanceof $modifierClassName) {
                            $methodName = JMSModifierHelper::getModifierSetterName($modifier);
                            $block->$methodName($value);
                        }
                    }
                }
            } elseif (in_array($attributeName, $allowedAttributes)) {
                $attributeClassName = JMSAttributeHelper::getAttributeInterfaceClassName($attributeName);
                if ($block instanceof $attributeClassName) {
                    $methodName = JMSAttributeHelper::getAttributeSetterName($attributeName);
                    $block->$methodName($nodeAttribute->value);
                }
            }
        }

        JMSModifierHelper::setBlockModifiers($block, $parentModifiers);

        return $block;
    }

    /**
     * @param JMSAbstractBlock $block
     * @return string
     */
    private function getContentFromBlock(JMSAbstractBlock $block)
    {
        $tagName = $this->getTagNameByBlock($block);
        $modifiers = $this->clearBlockModifiers($tagName, JMSModifierHelper::getBlockModifiers($block));
        $attributes = JMSAttributeHelper::getBlockAttributes($block);

        if ($tagName == 'span' && empty($modifiers) && empty($attributes)) {
            return $block->getContent();
        }

        $return = '<'.$tagName.$this->getBlockClasses($modifiers).$this->getBlockAttributes($attributes).'>';

        if ($block instanceof JMSAbstractContentBlock || $block instanceof JMSCollectionBlock) {
            if ($block instanceof JMSAbstractContentBlock) {
                $content = $block->getContent();
            } elseif ($block instanceof JMSVideoBlock) {
                $content = '<embed />';
            } else {
                $content = $this->getContentFromCollection($block);
            }

            $return .= $content.'</'.$tagName.'>';
        }

        return $return;
    }

    /**
     * @param JMSCollectionBlock $collectionBlock
     * @return string
     */
    private function getContentFromCollection(JMSCollectionBlock $collectionBlock)
    {
        $content = '';

        foreach ($collectionBlock as $block) {
            $content .= $this->getContentFromBlock($block);
        }

        return $content;
    }

    /**
     * @param string $name
     * @param $value
     * @return JMSAbstractBlock
     * @throws BadBlockNameException
     */
    private function createBlock($name, $value)
    {
        switch ($name) {
            case 'span':
                $block = (new JMSTextBlock($value));
                break;
            case 'u':
            case 'b':
            case 'i':
            case 'del':
                $block = (new JMSTextBlock($value));
                $block->setDecoration(array_search($name, $this->getDecorations()));
                break;
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
                $block = (new JMSHeadlineBlock($value));
                $block->setWeight(array_search($name, $this->getWeights()));
                break;
            case 'img':
                $block = new JMSImageBlock();
                break;
            case 'p':
                $block = new JMSParagraphBlock($value);
                break;
            case 'blockquote':
                $block = new JMSBlockquoteBlock($value);
                break;
            case 'object':
                $block = new JMSVideoBlock();
                break;
            default:
                throw new BadBlockNameException('Class for tag "'.$name.'" not found');
                break;
        }

        return $block;
    }

    /**
     * @param array $attributes
     * @return string
     */
    private function getBlockAttributes(array $attributes)
    {
        if (empty($attributes)) {
            return '';
        }

        $return = [];

        foreach ($attributes as $name => $value) {
            $return[] = $this->getAttributeByName($name).'="'.$value.'"';
        }

        return ' '.implode(' ', $return);
    }

    /**
     * @param string $tagName
     * @param array $modifiers
     * @return array
     */
    private function clearBlockModifiers($tagName, array $modifiers)
    {
        if (in_array($tagName, array_values($this->getWeights()))) {
            unset($modifiers['weight']);
        } elseif (in_array($tagName, array_values($this->getDecorations()))) {
            unset($modifiers['decoration'][0]);
        }

        return $modifiers;
    }

    /**
     * @param array $modifiers
     * @return string
     */
    private function getBlockClasses(array $modifiers)
    {
        if (empty($modifiers)) {
            return '';
        }

        $classes = [];

        foreach ($modifiers as $name => $value) {
            if (is_array($value)) {
                if ((count($value) > 0)) {
                    $classes[] = trim(' '.$name.'-'.implode(' '.$name.'-', $value));
                }
            } elseif (is_string($value)) {
                $classes[] = $name . '-' . $value;
            }
        }

        if (!empty($classes)) {
            return ' class="'.trim(implode(' ', $classes)).'"';
        }

        return '';
    }

    /**
     * @param JMSAbstractBlock $block
     * @return null
     */
    private function getTagNameByBlock(JMSAbstractBlock $block)
    {
        switch ($block->getBlockName()) {
            case 'image':
                return 'img';
            case 'text':
                return $this->getDecorationTagName($block->getDecoration());
            case 'paragraph':
                return 'p';
            case 'blockquote':
                return 'blockquote';
            case 'headline':
                return $this->getWeightTagName($block->getWeight());
            case 'video':
                return 'object';
            default:
                return null;
        }
    }

    /**
     * @param array $decorations
     * @return string
     */
    private function getDecorationTagName(array $decorations)
    {
        $return = 'span';

        if (!empty($decorations) && !empty($this->getDecorations()[$decorations[0]])) {
            $return = $this->getDecorations()[$decorations[0]];
        }

        return $return;
    }

    /**
     * @return array
     */
    private function getDecorations()
    {
        return [
            'bold' => 'b',
            'italic' => 'i',
            'del' => 'del',
            'underline' => 'u',
        ];
    }

    /**
     * @param string $weight
     * @return string
     */
    private function getWeightTagName($weight)
    {
        return $this->getWeights()[$weight];
    }

    /**
     * @return array
     */
    private function getWeights()
    {
        return [
            'xs' => 'h4',
            'sm' => 'h3',
            'md' => 'h2',
            'lg' => 'h1',
        ];
    }

    /**
     * @param $name
     * @return string
     */
    private function getAttributeByName($name)
    {
        if ($key = array_search($name, $this->getAttributesMap())) {
            return $key;
        }

        return $name;
    }

    /**
     * @return array
     */
    private function getAttributesMap()
    {
        return [
            'data-paragraph-id' => 'paragraphId',
            'data-video-src' => 'videoSrc',
            'data-video-id' => 'videoId',
            'data-video-provider' => 'videoProvider',
        ];
    }
}
