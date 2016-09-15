<?php

namespace Mildberry\JMSFormat\Parser;

use Mildberry\JMSFormat\Block\JMSCollectionBlock;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
interface ParserInterface
{
    /**
     * @param $content
     * @return JMSCollectionBlock
     */
    public function toCollection($content);

    /**
     * @param JMSCollectionBlock $collection
     * @return string
     */
    public function toContent(JMSCollectionBlock $collection);
}
