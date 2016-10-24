<?php

namespace Mildberry\JMSFormat\Block;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSBlockquoteBlock extends JMSCollectionBlock
{
    /**
     * @var string
     */
    protected $blockName = 'blockquote';

    /**
     * @var array
     */
    protected $allowedBlocks = ['text', 'image', 'video'];
}
