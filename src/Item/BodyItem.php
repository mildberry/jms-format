<?php

namespace Mildberry\Library\ContentFormatter\Item;

use Mildberry\Library\ContentFormatter\Modifier\InterfaceAlignmentModifier;
use Mildberry\Library\ContentFormatter\Modifier\TraitAlignmentModifier;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class BodyItem extends AbstractCollection
{
    /**
     * @var string
     */
    protected $blockName = 'body';
}
