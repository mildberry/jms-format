<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Modifier\AlignmentModifierInterface;
use Mildberry\JMSFormat\Modifier\AlignmentModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSParagraphCollectionBlock extends JMSCollectionBlock implements AlignmentModifierInterface
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
