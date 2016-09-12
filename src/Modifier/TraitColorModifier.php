<?php

namespace Mildberry\Library\ContentFormatter\Modifier;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait TraitColorModifier
{
    /**
     * @var string
     */
    protected $color;

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     *
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }
}
