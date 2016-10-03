<?php

namespace Mildberry\JMSFormat\Interfaces;

use Mildberry\JMSFormat\Block\JMSCollectionBlock;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
interface ParserInterface
{
    /**
     * @param string $content
     * @return JMSCollectionBlock
     */
    public function toCollection($content);

    /**
     * @param JMSCollectionBlock $collection
     * @return string
     */
    public function toContent(JMSCollectionBlock $collection);
}
