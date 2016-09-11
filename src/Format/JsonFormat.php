<?php

namespace Mildberry\Library\ContentFormatter\Format;

use Mildberry\Library\ContentFormatter\Item\CollectionItem;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JsonFormat implements FormatInterface
{
    /**
     * @param $content
     * @return CollectionItem
     */
    public function toCollection($content)
    {
        new CollectionItem();
    }

    /**
     * @param CollectionItem $collection
     * @return string
     */
    public function toContent(CollectionItem $collection)
    {
        return '';
    }
}
