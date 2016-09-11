<?php

namespace Mildberry\Library\ContentFormatter\Format;

use Mildberry\Library\ContentFormatter\Item\CollectionItem;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
interface FormatInterface
{
    /**
     * @param $content
     * @return CollectionItem
     */
    public function toCollection($content);

    /**
     * @param CollectionItem $collection
     * @return string
     */
    public function toContent(CollectionItem $collection);
}
