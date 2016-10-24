<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\JMSAttributeHelper;
use Mildberry\JMSFormat\JMSModifierHelper;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
abstract class JMSAbstractBlock
{
    /**
     * @var string
     */
    protected $blockName;

    /**
     * @return string
     */
    public function getBlockName()
    {
        return $this->blockName;
    }
}
