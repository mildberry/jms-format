<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Interfaces\FloatingModifierInterface;
use Mildberry\JMSFormat\Interfaces\SizeModifierInterface;
use Mildberry\JMSFormat\Interfaces\SrcModifierInterface;
use Mildberry\JMSFormat\Modifier\FloatingModifierTrait;
use Mildberry\JMSFormat\Modifier\SizeModifierTrait;
use Mildberry\JMSFormat\Modifier\SrcModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSImageBlock extends JMSAbstractBlock implements SrcModifierInterface, FloatingModifierInterface, SizeModifierInterface
{
    use SrcModifierTrait;
    use FloatingModifierTrait;
    use SizeModifierTrait;

    /**
     * @var string
     */
    protected $blockName = 'image';
}
