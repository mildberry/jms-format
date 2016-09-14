<?php

namespace Mildberry\JMSFormat\Format;

use DOMDocument;
use DOMElement;
use DOMNamedNodeMap;
use DOMNodeList;
use DOMText;
use Mildberry\JMSFormat\Exception\BadTagNameException;
use Mildberry\JMSFormat\Item\AbstractItem;
use Mildberry\JMSFormat\Item\BlockQuoteItem;
use Mildberry\JMSFormat\Item\CollectionItem;
use Mildberry\JMSFormat\Item\HeadLineItem;
use Mildberry\JMSFormat\Item\ImageItem;
use Mildberry\JMSFormat\Item\ParagraphItem;
use Mildberry\JMSFormat\Item\TextItem;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class HtmlFormat implements FormatInterface
{
    const ROOT_NODE_ID = 'DOMRootBodyElement';

    const ALLOWED_TAGS = '<p><span><img><b><i><del><blockquote><h1><h2><h3><h4>';

    /**
     * @param string $content
     * @return CollectionItem
     */
    public function toCollection($content)
    {
        return $this->createCollectionFormHtml($content);
    }

    /**
     * @param CollectionItem $collection
     * @return string
     */
    public function toContent(CollectionItem $collection)
    {
        return ''; //TODO: make this
    }

    /**
     * @param string $content
     * @return CollectionItem
     */
    private function createCollectionFormHtml($content)
    {
        $collection = new CollectionItem();

        foreach ($this->createDOMElementsByHtml($content) as $element) {
            if ($element instanceof DOMText) {
                if ($text = trim(strip_tags($element->nodeValue))) {
                    $collection->push(new TextItem($text));
                }
            } else {
                $collection->push($this->createItemFromDOMElement($element));
            }
        }

        return $collection;
    }

    /**
     * @param string $content
     * @return DOMElement
     */
    private function createDOMElementsByHtml($content)
    {
        $DOMDocument = new DOMDocument('1.0', 'UTF-8');

        libxml_use_internal_errors(true);
        $DOMDocument->loadHTML('<body id="'.self::ROOT_NODE_ID.'">'.strip_tags($content, self::ALLOWED_TAGS).'</body>');
        libxml_clear_errors();

        return $DOMDocument->getElementById(self::ROOT_NODE_ID)->childNodes;
    }

    /**
     * @param DOMElement $element
     * @return AbstractItem
     */
    private function createItemFromDOMElement($element)
    {
        $tagName = mb_strtolower($element->tagName);
        $className = $this->getClassNameByTagName($tagName);

        $item = $this->updateBlockModifiersByTagNam(new $className(strip_tags($element->nodeValue)), $tagName, $element->attributes);

        if ($element->hasChildNodes()) {
            foreach ($element->childNodes as $childNode) {
                if (XML_ELEMENT_NODE === $childNode->nodeType) {
                    $item->push($this->createItemFromDOMElement($childNode));
                }
            }
        }

        if ($item instanceof CollectionItem) {
            $item = $this->updateCollectionBlocksByHTML($item, $this->getDOMElementHtmlValue($element));
        }

        return $item;
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
     * @param CollectionItem $item
     * @param string $html
     * @return CollectionItem
     */
    private function updateCollectionBlocksByHTML($item, $html)
    {
        $pos = strpos($html, '<');
        if ($pos !== false) {
            if ($pos > 0) {
                $item->unshift(new TextItem(substr($html, 0, $pos)));
            }
            if ($html = substr($html, strrpos($html, '>')+1)) {
                $item->push(new TextItem($html));
            }
        } else {
            $item->push(new TextItem($html));
        }

        return $item;
    }

    /**
     * @param AbstractItem $item
     * @param string $tagName
     * @param DOMNamedNodeMap $attributes
     * @return AbstractItem
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
                return TextItem::class;
            case 'h1': case 'h2': case 'h3': case 'h4':
                return HeadLineItem::class;
            case 'img':
                return ImageItem::class;
            case 'p':
                return ParagraphItem::class;
            case 'blockquote':
                return BlockQuoteItem::class;
            case 'body':
                return CollectionItem::class;
        }

        throw new BadTagNameException();
    }
}
