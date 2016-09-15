<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Modifier\FloatingModifierInterface;
use Mildberry\JMSFormat\Modifier\SizeModifierInterface;
use Mildberry\JMSFormat\Modifier\SrcModifierInterface;
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
