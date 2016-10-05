<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Attribute\SourceAttributeTrait;
use Mildberry\JMSFormat\Interfaces\FloatingModifierInterface;
use Mildberry\JMSFormat\Interfaces\SizeModifierInterface;
use Mildberry\JMSFormat\Interfaces\SourceAttributeInterface;
use Mildberry\JMSFormat\Modifier\FloatingModifierTrait;
use Mildberry\JMSFormat\Modifier\SizeModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSImageBlock extends JMSAbstractBlock implements SourceAttributeInterface, FloatingModifierInterface, SizeModifierInterface
{
    use SourceAttributeTrait;
    use FloatingModifierTrait;
    use SizeModifierTrait;

    /**
     * @var string
     */
    protected $blockName = 'image';

    /**
     * @var string
     */
    protected $tagName = 'img';

    /**
     * @var array
     */
    protected $modifiers;

    /**
     * @var array
     */
    protected $attributes;
}
