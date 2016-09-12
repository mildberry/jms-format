<?php

namespace Mildberry\Library\ContentFormatter\Format;

use Mildberry\Library\ContentFormatter\Item\AbstractCollection;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
interface FormatInterface
{
    /**
     * @param $content
     * @return AbstractCollection
     */
    public function toCollection($content);

    /**
     * @param AbstractCollection $collection
     * @return string
     */
    public function toContent(AbstractCollection $collection);
}
