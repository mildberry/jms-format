<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Attribute\HrefAttributeTrait;
use Mildberry\JMSFormat\Interfaces\HrefAttributeInterface;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSLinkBlock extends JMSCollectionBlock implements HrefAttributeInterface
{
    use HrefAttributeTrait;

    /**
     * @var string
     */
    protected $blockName = 'link';

    /**
     * @var array
     */
    protected $allowedBlocks = ['text'];
}
