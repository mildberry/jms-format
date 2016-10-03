<?php

namespace Mildberry\JMSFormat\Parser;

use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Interfaces\ParserInterface;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JmsParser implements ParserInterface
{
    const VERSION = 'v1';

    /**
     * @param string $content
     * @return JMSCollectionBlock
     */
    public function toCollection($content)
    {
        $collection = new JMSCollectionBlock();

        $data = json_decode($content, true);

        if (!empty($data['version']) && !empty($data['content'])) {
            $collection->loadFromJMSArray($data);
        }

        return $collection;
    }

    /**
     * @param JMSCollectionBlock $collection
     * @return string
     */
    public function toContent(JMSCollectionBlock $collection)
    {
        $content = [
            'version' => self::VERSION,
            'content' => $collection->getContentAsJMSArray(),
        ];

        return json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
