<?php

namespace Mildberry\Library\ContentFormatter\Format;

use Mildberry\Library\ContentFormatter\Item\AbstractCollection;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class HtmlFormat implements FormatInterface
{
    /**
     * @param $content
     * @return AbstractCollection
     */
    public function toCollection($content)
    {
        return new AbstractCollection();
    }

    /**
     * @param AbstractCollection $collection
     * @return string
     */
    public function toContent(AbstractCollection $collection)
    {
        return '';
    }
}
