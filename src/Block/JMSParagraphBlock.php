<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Attribute\DataParagraphIdAttributeTrait;
use Mildberry\JMSFormat\Interfaces\AlignmentModifierInterface;
use Mildberry\JMSFormat\Interfaces\DataParagraphIdAttributeInterface;
use Mildberry\JMSFormat\Modifier\AlignmentModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSParagraphBlock extends JMSCollectionBlock implements AlignmentModifierInterface, DataParagraphIdAttributeInterface
{
    use AlignmentModifierTrait;
    use DataParagraphIdAttributeTrait;

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
    protected $allowedBlocks = ['text', 'image'];
}
