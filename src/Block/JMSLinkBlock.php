<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Attribute\HrefAttributeTrait;
use Mildberry\JMSFormat\Attribute\TargetAttributeTrait;
use Mildberry\JMSFormat\Interfaces\HrefAttributeInterface;
use Mildberry\JMSFormat\Interfaces\TargetAttributeInterface;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSLinkBlock extends JMSCollectionBlock implements HrefAttributeInterface, TargetAttributeInterface
{
    use HrefAttributeTrait;
    use TargetAttributeTrait;

    /**
     * @var string
     */
    protected $blockName = 'link';

    /**
     * @var array
     */
    protected $allowedBlocks = ['text'];
}
