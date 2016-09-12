<?php

namespace Mildberry\Library\ContentFormatter\Modifier;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait TraitSrcModifier
{
    /**
     * @var string
     */
    protected $src;

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param string $src
     *
     * @return $this
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }
}
