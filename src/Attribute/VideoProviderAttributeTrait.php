<?php

namespace Mildberry\JMSFormat\Attribute;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait VideoProviderAttributeTrait
{
    /**
     * @var string
     */
    protected $videoProvider;

    /**
     * @return string
     */
    public function getVideoprovider()
    {
        return $this->videoProvider;
    }

    /**
     * @param string $videoProvider
     *
     * @return $this
     */
    public function setVideoProvider($videoProvider)
    {
        $this->videoProvider = $videoProvider;

        return $this;
    }
}
