<?php

namespace Mildberry\JMSFormat\Parser;

use DOMDocument;
use DOMElement;
use DOMNamedNodeMap;
use DOMNodeList;
use DOMText;
use Mildberry\JMSFormat\Exception\BadTagNameException;
use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSBlockQuoteCollectionBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSHeadLineCollectionBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSParagraphCollectionBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class HtmlParser implements ParserInterface
{
    const ROOT_NODE_ID = 'DOMRootBodyElement';

    const ALLOWED_TAGS = '<p><span><img><b><i><del><blockquote><h1><h2><h3><h4>';

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
        // Need make this functional
        return '';
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
        $DOMDocument->loadHTML('<body id="'.self::ROOT_NODE_ID.'">'.strip_tags($content, self::ALLOWED_TAGS).'</body>');

        return $DOMDocument->getElementById(self::ROOT_NODE_ID)->childNodes;
    }

    /**
     * @param DOMNodeList $elements
     * @return JMSCollectionBlock
     */
    public function createCollectionByDOMElements(DOMNodeList $elements)
    {
        $collection = new JMSCollectionBlock();

        foreach ($elements as $element) {
            // as text has no tags
            if ($element instanceof DOMText) {
                if ($text = strip_tags($element->nodeValue)) {
                    $collection->addBlock(new JMSTextBlock($text));
                }
            } elseif ($element instanceof DOMElement) {
                $item = $this->createItemFromDOMElement($element);

                if ($element->hasChildNodes()) {
                    if ($item instanceof JMSCollectionBlock) {
                        $item->addCollection($this->createCollectionByDOMElements($element->childNodes));
                        //$item = $this->updateCollectionBlockByHTML($item, $this->getDOMElementHtmlValue($element));
                        $collection->addBlock($item);
                    } else {
                        $collection->addCollection($this->createCollectionByDOMElements($element->childNodes));
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
     * @return JMSAbstractBlock
     */
    private function createItemFromDOMElement($element)
    {
        $tagName = mb_strtolower($element->tagName);
        $className = $this->getClassNameByTagName($tagName);

        return $this->updateBlockModifiersByTagNam(new $className(strip_tags($element->nodeValue)), $tagName, $element->attributes);
    }

    /**
     * @param DOMElement $element
     * @return string
     */
    private function getDOMElementHtmlValue(DOMElement $element)
    {
        $innerHTML = '';
        foreach ($element->childNodes as $child) {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return $innerHTML;
    }

    /**
     * @param JMSCollectionBlock $item
     * @param string $html
     * @return JMSCollectionBlock
     */
    private function updateCollectionBlockByHTML($item, $html)
    {
        $pos = strpos($html, '<');
        if ($pos !== false) {
            if ($pos > 0) {
                $item->insertFirstBlock(new JMSTextBlock(substr($html, 0, $pos)));
            }
            if ($html = substr($html, strrpos($html, '>')+1)) {
                $item->addBlock(new JMSTextBlock($html));
            }
        } else {
            $item->addBlock(new JMSTextBlock($html));
        }

        return $item;
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
            case 'h1': $item->setWeight('lg'); break;
            case 'h2': $item->setWeight('md'); break;
            case 'h3': $item->setWeight('sm'); break;
            case 'h4': $item->setWeight('xs'); break;
            case 'img': $item->setSrc($attributes->getNamedItem('src')->nodeValue); break;
        }

        return $item;
    }

    /**
     * @param string $name
     * @return string
     * @throws BadTagNameException
     */
    private function getClassNameByTagName($name)
    {
        switch ($name) {
            case 'span': case 'b': case 'i': case 'del':
                return JMSTextBlock::class;
            case 'h1': case 'h2': case 'h3': case 'h4':
                return JMSHeadLineCollectionBlock::class;
            case 'img':
                return JMSImageBlock::class;
            case 'p':
                return JMSParagraphCollectionBlock::class;
            case 'blockquote':
                return JMSBlockQuoteCollectionBlock::class;
            case 'body':
                return JMSCollectionBlock::class;
        }

        throw new BadTagNameException();
    }
}
