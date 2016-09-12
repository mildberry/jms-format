<?php

namespace Mildberry\Library\ContentFormatter\Item;

use Mildberry\Library\ContentFormatter\Modifier\InterfaceAlignmentModifier;
use Mildberry\Library\ContentFormatter\Modifier\TraitAlignmentModifier;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class ParagraphItem extends AbstractCollection implements InterfaceAlignmentModifier
{
    use TraitAlignmentModifier;

    /**
     * @var string
     */
    protected $blockName = 'paragraph';
}
