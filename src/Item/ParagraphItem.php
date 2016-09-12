<?php

namespace Mildberry\Library\ContentFormatter\Item;

use Mildberry\Library\ContentFormatter\Modifier\AlignmentModifierInterface;
use Mildberry\Library\ContentFormatter\Modifier\AlignmentModifierTrait;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class ParagraphItem extends CollectionItem implements AlignmentModifierInterface
{
    use AlignmentModifierTrait;

    /**
     * @var string
     */
    protected $blockName = 'paragraph';
}
