<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Modifier\ColorModifierInterface;
use Mildberry\JMSFormat\Modifier\ColorModifierTrait;
use Mildberry\JMSFormat\Modifier\DecorationModifierInterface;
use Mildberry\JMSFormat\Modifier\DecorationModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class TextBlock extends AbstractContentBlock implements ColorModifierInterface, DecorationModifierInterface
{
    use ColorModifierTrait;
    use DecorationModifierTrait;

    /**
     * @var string
     */
    protected $blockName = 'text';
}
