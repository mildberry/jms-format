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
     * @param $content
     * @return JMSCollectionBlock
     */
    public function toCollection($content)
    {
        return new JMSCollectionBlock();
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
