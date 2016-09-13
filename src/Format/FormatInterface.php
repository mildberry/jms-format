<?php

namespace Mildberry\JMSFormat\Format;

use Mildberry\JMSFormat\Item\CollectionItem;

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
