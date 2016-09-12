<?php

namespace Mildberry\Library\ContentFormatter\Item;

use Mildberry\Library\ContentFormatter\Modifier\InterfaceFloatingModifier;
use Mildberry\Library\ContentFormatter\Modifier\InterfaceSizeModifier;
use Mildberry\Library\ContentFormatter\Modifier\InterfaceSrcModifier;
use Mildberry\Library\ContentFormatter\Modifier\TraitFloatingModifier;
use Mildberry\Library\ContentFormatter\Modifier\TraitSizeModifier;
use Mildberry\Library\ContentFormatter\Modifier\TraitSrcModifier;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class ImageItem extends AbstractItem implements InterfaceSrcModifier, InterfaceFloatingModifier, InterfaceSizeModifier
{
    use TraitSrcModifier;
    use TraitFloatingModifier;
    use TraitSizeModifier;

    /**
     * @var string
     */
    protected $blockName = 'image';
}
