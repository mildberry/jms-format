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
     * @var string
     */
    protected $tagName = 'blockquote';

    /**
     * @var array
     */
    protected $modifiers;

    /**
     * @var array
     */
    protected $allowedBlocks = ['text', 'image'];
}
