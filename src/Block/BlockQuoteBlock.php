<?php

namespace Mildberry\JMSFormat\Block;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class BlockQuoteBlock extends CollectionBlock
{
    /**
     * @var string
     */
    protected $blockName = 'blockquote';

    /**
     * @var array
     */
    protected $allowedBlocks = ['text', 'image'];
}
