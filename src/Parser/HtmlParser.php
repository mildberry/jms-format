<?php

namespace Mildberry\JMSFormat\Parser;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMText;
use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\Interfaces\ParserInterface;
use Mildberry\JMSFormat\JMSBlockHelper;

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
        return $collection->getContentAsHTMLText();
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
     * @param array $parentModifiers
     * @return JMSAbstractBlock
     */
    private function createItemFromDOMElement($element, $parentModifiers = [])
    {
        $tagName = mb_strtolower($element->tagName);

        return JMSBlockHelper::createBlockByTagName($tagName, strip_tags($element->nodeValue), $element->attributes, $parentModifiers);
    }
}
