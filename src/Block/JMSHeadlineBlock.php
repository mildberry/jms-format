<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Interfaces\WeightModifierInterface;
use Mildberry\JMSFormat\Modifier\WeightModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSHeadlineBlock extends JMSCollectionBlock implements WeightModifierInterface
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

    /**
     * @var string
     */
    protected $tagName = 'h1';

    /**
     * @var array
     */
    protected $modifiers;

    /**
     * @return string
     */
    public function getTagName()
    {
        if ($tagName = $this->getTagNameByDecorationValue()) {
            return $tagName;
        }

        return $this->tagName;
    }
}
