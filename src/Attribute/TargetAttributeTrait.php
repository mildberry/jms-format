<?php

namespace Mildberry\JMSFormat\Attribute;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait TargetAttributeTrait
{

    protected $target;

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param string $target
     *
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }
}
