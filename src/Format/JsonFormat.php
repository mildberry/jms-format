<?php

namespace Mildberry\JMSFormat\Format;

use Mildberry\JMSFormat\Item\CollectionItem;
use Mildberry\JMSFormat\Item\AbstractContentItem;

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
            'content' => $this->getArrayItemsByCollection($collection),
        ];

        return json_encode($content);
    }

    /**
     * @param CollectionItem $collection
     * @return array
     */
    private function getArrayItemsByCollection(CollectionItem $collection)
    {
        $contents = [];

        foreach ($collection as $item)
        {
            $content = [
                'block' => $item->getBlockName(),
                'modifiers' => $item->getModifiers(),
            ];

            if ($item instanceof CollectionItem) {
                $content['content'] = $this->getArrayItemsByCollection($item);
            }

            if ($item instanceof AbstractContentItem) {
                $content['content'] = $item->getContent();
            }

            $contents[] = $content;
        }

        return $contents;
    }
}
