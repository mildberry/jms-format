<?php

namespace Mildberry\JMSFormat\Item;

use Mildberry\JMSFormat\Modifier\WeightModifierInterface;
use Mildberry\JMSFormat\Modifier\WeightModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class HeadLineItem extends CollectionItem implements WeightModifierInterface
{
    use WeightModifierTrait;

    /**
     * @var string
     */
    protected $blockName = 'headline';

    /**
     * @var array
     */
    protected $allowedBlocks = ['text'];
}
