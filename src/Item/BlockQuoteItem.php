<?php

namespace Mildberry\JMSFormat\Item;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class BlockQuoteItem extends CollectionItem
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
