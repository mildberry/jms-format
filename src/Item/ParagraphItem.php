<?php

namespace Mildberry\JMSFormat\Item;

use Mildberry\JMSFormat\Modifier\AlignmentModifierInterface;
use Mildberry\JMSFormat\Modifier\AlignmentModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class ParagraphItem extends CollectionItem implements AlignmentModifierInterface
{
    use AlignmentModifierTrait;

    /**
     * @var string
     */
    protected $blockName = 'paragraph';

    /**
     * @var array
     */
    protected $allowedBlocks = ['text', 'image'];
}
