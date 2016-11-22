<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\Attribute\VideoIdAttributeTrait;
use Mildberry\JMSFormat\Attribute\VideoProviderAttributeTrait;
use Mildberry\JMSFormat\Attribute\VideoSrcAttributeTrait;
use Mildberry\JMSFormat\Interfaces\SizeModifierInterface;
use Mildberry\JMSFormat\Interfaces\VideoidAttributeInterface;
use Mildberry\JMSFormat\Interfaces\VideoproviderAttributeInterface;
use Mildberry\JMSFormat\Interfaces\VideosrcAttributeInterface;
use Mildberry\JMSFormat\Modifier\SizeModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSVideoBlock extends JMSCollectionBlock implements SizeModifierInterface, VideosrcAttributeInterface , VideoidAttributeInterface, VideoproviderAttributeInterface
{
    use SizeModifierTrait;
    use VideoSrcAttributeTrait;
    use VideoIdAttributeTrait;
    use VideoProviderAttributeTrait;

    /**
     * @var string
     */
    protected $blockName = 'video';

    /**
     * @var array
     */
    protected $allowedBlocks = [];
}
