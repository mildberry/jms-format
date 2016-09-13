<?php

namespace Mildberry\JMSFormat\Format;

use Mildberry\JMSFormat\Item\CollectionItem;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormat implements FormatInterface
{
    /**
     * @param $content
     * @return CollectionItem
     */
    public function toCollection($content)
    {
        return new CollectionItem();
    }

    /**
     * @param CollectionItem $collection
     * @return string
     */
    public function toContent(CollectionItem $collection)
    {
        $content = [
            'version' => 'v1',
            'content' => $collection->getContentAsJMSArray(),
        ];

        return json_encode($content);
    }
}
