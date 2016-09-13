<?php

namespace Mildberry\JMSFormat\Item;

use Mildberry\JMSFormat\Modifier\ColorModifierInterface;
use Mildberry\JMSFormat\Modifier\ColorModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class TextItem extends AbstractContentItem implements ColorModifierInterface
{
    use ColorModifierTrait;

    /**
     * @var string
     */
    protected $blockName = 'text';
}
