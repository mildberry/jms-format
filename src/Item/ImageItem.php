<?php

namespace Mildberry\Library\ContentFormatter\Item;

use Mildberry\Library\ContentFormatter\Modifier\FloatingModifierInterface;
use Mildberry\Library\ContentFormatter\Modifier\SizeModifierInterface;
use Mildberry\Library\ContentFormatter\Modifier\SrcModifierInterface;
use Mildberry\Library\ContentFormatter\Modifier\FloatingModifierTrait;
use Mildberry\Library\ContentFormatter\Modifier\SizeModifierTrait;
use Mildberry\Library\ContentFormatter\Modifier\SrcModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class ImageItem extends AbstractItem implements SrcModifierInterface, FloatingModifierInterface, SizeModifierInterface
{
    use SrcModifierTrait;
    use FloatingModifierTrait;
    use SizeModifierTrait;

    /**
     * @var string
     */
    protected $blockName = 'image';
}
