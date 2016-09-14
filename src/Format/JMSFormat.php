<?php

namespace Mildberry\JMSFormat\Format;

use Mildberry\JMSFormat\Block\CollectionBlock;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormat implements FormatInterface
{
    /**
     * @param $content
     * @return CollectionBlock
     */
    public function toCollection($content)
    {
        return new CollectionBlock();
    }

    /**
     * @param CollectionBlock $collection
     * @return string
     */
    public function toContent(CollectionBlock $collection)
    {
        $content = [
            'version' => 'v1',
            'content' => $collection->getContentAsJMSArray(),
        ];

        return json_encode($content);
    }
}
