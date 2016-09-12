<?php

namespace Mildberry\Library\ContentFormatter\Format;

use Mildberry\Library\ContentFormatter\Item\AbstractCollection;
use Mildberry\Library\ContentFormatter\Item\AbstractContentItem;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JsonFormat implements FormatInterface
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
        $content = [
            'version' => 'v1',
            'content' => $this->getArrayItemsByCollection($collection),
        ];

        return json_encode($content);
    }

    /**
     * @param AbstractCollection $collection
     * @return array
     */
    private function getArrayItemsByCollection(AbstractCollection $collection)
    {
        $contents = [];

        foreach ($collection as $item)
        {
            $content = [
                'block' => $item->getBlockName(),
                'modifiers' => $item->getModifiers(),
            ];

            if ($item instanceof AbstractCollection) {
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
