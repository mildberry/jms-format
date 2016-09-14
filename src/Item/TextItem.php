<?php

namespace Mildberry\JMSFormat\Item;

use Mildberry\JMSFormat\Modifier\ColorModifierInterface;
use Mildberry\JMSFormat\Modifier\ColorModifierTrait;
use Mildberry\JMSFormat\Modifier\DecorationModifierInterface;
use Mildberry\JMSFormat\Modifier\DecorationModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class TextItem extends AbstractContentItem implements ColorModifierInterface, DecorationModifierInterface
{
    use ColorModifierTrait;
    use DecorationModifierTrait;

    /**
     * @var string
     */
    protected $blockName = 'text';
}
