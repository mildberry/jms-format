<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Attribute\ParagraphIdAttributeTrait;
use Mildberry\JMSFormat\Interfaces\AlignmentModifierInterface;
use Mildberry\JMSFormat\Interfaces\ParagraphidAttributeInterface;
use Mildberry\JMSFormat\Modifier\AlignmentModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSParagraphBlock extends JMSCollectionBlock implements AlignmentModifierInterface, ParagraphidAttributeInterface
{
    use AlignmentModifierTrait;
    use ParagraphIdAttributeTrait;

    /**
     * @var string
     */
    protected $blockName = 'paragraph';

    /**
     * @var array
     */
    protected $allowedBlocks = ['text', 'image', 'video'];
}
