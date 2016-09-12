<?php

namespace Mildberry\Library\ContentFormatter\Item;

use Mildberry\Library\ContentFormatter\Modifier\ColorModifierInterface;
use Mildberry\Library\ContentFormatter\Modifier\ColorModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class TextItem extends AbstractContentItem implements ColorModifierInterface
{
    use ColorModifierTrait;

    /**
     * @var string
     */
    protected $blockName = 'text';
}
