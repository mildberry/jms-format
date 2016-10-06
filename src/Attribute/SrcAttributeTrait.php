<?php

namespace Mildberry\JMSFormat\Attribute;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait SrcAttributeTrait
{

    private $src;

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
