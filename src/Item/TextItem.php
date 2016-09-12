<?php

namespace Mildberry\Library\ContentFormatter\Item;

use Mildberry\Library\ContentFormatter\Modifier\InterfaceColorModifier;
use Mildberry\Library\ContentFormatter\Modifier\TraitColorModifier;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class TextItem extends AbstractContentItem implements InterfaceColorModifier
{
    use TraitColorModifier;

    /**
     * @var string
     */
    protected $blockName = 'text';
}
