<?php

namespace Mildberry\JMSFormat\Attribute;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait SourceAttributeTrait
{
    /**
     * @return string
     */
    public function getSrc()
    {
        return (!empty($this->attributes['src'])) ? $this->attributes['src'] : null;
    }

    /**
     * @param string $src
     *
     * @return $this
     */
    public function setSrc($src)
    {
        $this->attributes['src'] = $src;

        return $this;
    }
}
