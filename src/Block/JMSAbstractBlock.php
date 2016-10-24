<?php

namespace Mildberry\JMSFormat\Block;

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
