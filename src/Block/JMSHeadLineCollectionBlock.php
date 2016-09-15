<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Modifier\WeightModifierInterface;
use Mildberry\JMSFormat\Modifier\WeightModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSHeadLineCollectionBlock extends JMSCollectionBlock implements WeightModifierInterface
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
