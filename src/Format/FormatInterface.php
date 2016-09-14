<?php

namespace Mildberry\JMSFormat\Format;

use Mildberry\JMSFormat\Block\CollectionBlock;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
interface FormatInterface
{
    /**
     * @param $content
     * @return CollectionBlock
     */
    public function toCollection($content);

    /**
     * @param CollectionBlock $collection
     * @return string
     */
    public function toContent(CollectionBlock $collection);
}
