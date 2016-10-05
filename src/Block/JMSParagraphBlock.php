<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Interfaces\AlignmentModifierInterface;
use Mildberry\JMSFormat\Modifier\AlignmentModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSParagraphBlock extends JMSCollectionBlock implements AlignmentModifierInterface
{
    use AlignmentModifierTrait;

    /**
     * @var string
     */
    protected $blockName = 'paragraph';

    /**
     * @var string
     */
    protected $tagName = 'p';

    /**
     * @var array
     */
    protected $modifiers;

    /**
     * @var array
     */
    protected $allowedBlocks = ['text', 'image'];
}
