<?php

namespace Mildberry\JMSFormat\Parser;

use DOMDocument;
use DOMElement;
use DOMNamedNodeMap;
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
use Mildberry\JMSFormat\Interfaces\ParserInterface;
use Mildberry\JMSFormat\JMSBlockHelper;
use Mildberry\JMSFormat\JMSModifierHelper;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class HtmlParser implements ParserInterface
{
    const ROOT_NODE_ID = 'DOMRootBodyElement';

    const ALLOWED_TAGS = '<p><span><b><i><del><u><blockquote><h1><h2><h3><h4><img>';

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
        return $this->createHtmlFromCollection($collection);
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
     * @param JMSCollectionBlock $collection
     * @return string
     */
    private function createHtmlFromCollection(JMSCollectionBlock $collection)
    {
        $html = '';

        /** @var JMSAbstractBlock $block */
        foreach ($collection as $block) {
            if ($block instanceof JMSCollectionBlock) {
                $tag1 = JMSBlockHelper::getTagSourceByBlock($block);
                $html .= '<'.$tag1.'>';
                if ($block->count() == 1) {
                    $tag = JMSBlockHelper::getTagSourceByBlock($block[0]);
                    $html .= '<'.$tag.'>';
                    if ($block[0] instanceof JMSAbstractContentBlock) {
                        $html .= $block[0]->getContent().'</'.explode(' ', $tag)[0].'>';
                    }
                } else {
                    $html .= $this->createHtmlFromCollection($block);
                }
                $html .= '</'.explode(' ', $tag1)[0].'>';

            } else {
                $tag = JMSBlockHelper::getTagSourceByBlock($block);
                $html .= '<'.$tag.'>';
                if ($block instanceof JMSAbstractContentBlock) {
                    $html .= $block->getContent().'</'.explode(' ', $tag)[0].'>';
                }
            }
        }

        return $html;
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
                    $collection->addBlock((new JMSTextBlock($text))->setModifiers($modifiers));
                }
            } elseif ($element instanceof DOMElement) {
                $item = $this->createItemFromDOMElement($element, $modifiers);
                if ($element->hasChildNodes()) {
                    if ($item instanceof JMSCollectionBlock) {
                        $item->addCollection($this->createCollectionByDOMElements($element->childNodes));
                        $collection->addBlock($item);
                    } else {
                        $collection->addCollection($this->createCollectionByDOMElements($element->childNodes, $item->getModifiers()));
                    }
                } else {
                    $collection->addBlock($item);
                }
            }
        }

        return $collection;
    }

    /**
     * @param DOMElement $element
     * @param array $modifiers
     * @return JMSAbstractBlock
     */
    private function createItemFromDOMElement($element, $modifiers = [])
    {
        $tagName = mb_strtolower($element->tagName);
        $item = (JMSBlockHelper::createBlockByTagName($tagName, strip_tags($element->nodeValue)));
        $item->setModifiers($modifiers);

        return $this->updateBlockModifiersByTagNam($item, $tagName, $element->attributes);
    }

    /**
     * @param JMSAbstractBlock $item
     * @param string $tagName
     * @param DOMNamedNodeMap $attributes
     * @return JMSAbstractBlock
     */
    private function updateBlockModifiersByTagNam($item, $tagName, DOMNamedNodeMap $attributes)
    {
        switch ($tagName) {
            case 'b': $item->setDecoration('bold'); break;
            case 'i': $item->setDecoration('italic'); break;
            case 'del': $item->setDecoration('del'); break;
            case 'u': $item->setDecoration('underline'); break;
            case 'h1': $item->setWeight('lg'); break;
            case 'h2': $item->setWeight('md'); break;
            case 'h3': $item->setWeight('sm'); break;
            case 'h4': $item->setWeight('xs'); break;
            case 'img': $item->setSrc($attributes->getNamedItem('src')->nodeValue); break;
        }

        if ($classes = $attributes->getNamedItem('class')) {
            foreach (explode(' ', $classes->nodeValue) as $class) {
                list($modifier, $value) = array_pad(explode('-', $class), 2, '');

                if ($modifier && $value) {
                    $modifierClassName = JMSModifierHelper::getModifierInterfaceClassName($modifier);
                    if ($item instanceof $modifierClassName) {
                        $methodName = JMSModifierHelper::getModifierSetterName($modifier);
                        $item->$methodName($value);
                    }
                }
            }
        }

        return $item;
    }
}
