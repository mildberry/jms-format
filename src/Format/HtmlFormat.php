<?php

namespace Mildberry\JMSFormat\Format;

use Mildberry\JMSFormat\Item\CollectionItem;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class HtmlFormat implements FormatInterface
{
    CONST ALLOWED_TAGS = '<p><span><img><b><i><del><blockquote>';

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
        return '';
    }

    /**
     * @param string $content
     * @return CollectionItem
     */
    private function createCollectionFormHtml($content)
    {
        $collection = new CollectionItem();

//        $content = strip_tags($content, self::ALLOWED_TAGS);
//        print $content;

        return $collection;
    }
}
