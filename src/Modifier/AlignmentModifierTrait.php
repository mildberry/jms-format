<?php

namespace Mildberry\Library\ContentFormatter\Modifier;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait AlignmentModifierTrait
{
    /**
     * @var string
     */
    protected $alignment;

    /**
     * @return string
     */
    public function getAlignment()
    {
        return $this->alignment;
    }

    /**
     * @param string $alignment
     *
     * @return $this
     */
    public function setAlignment($alignment)
    {
        $this->alignment = $alignment;

        return $this;
    }
}
