<?php

namespace Mildberry\Library\ContentFormatter\Modifier;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait TraitFloatingModifier
{
    /**
     * @var string
     */
    protected $floating;

    /**
     * @return string
     */
    public function getFloating()
    {
        return $this->floating;
    }

    /**
     * @param string $floating
     *
     * @return $this
     */
    public function setFloating($floating)
    {
        $this->floating = $floating;

        return $this;
    }
}
