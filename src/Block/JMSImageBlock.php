<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Attribute\SrcAttributeTrait;
use Mildberry\JMSFormat\Interfaces\FloatingModifierInterface;
use Mildberry\JMSFormat\Interfaces\SizeModifierInterface;
use Mildberry\JMSFormat\Interfaces\SrcAttributeInterface;
use Mildberry\JMSFormat\Modifier\FloatingModifierTrait;
use Mildberry\JMSFormat\Modifier\SizeModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSImageBlock extends JMSAbstractBlock implements SrcAttributeInterface, FloatingModifierInterface, SizeModifierInterface
{
    use SrcAttributeTrait;
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
}
