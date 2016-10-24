<?php

namespace Mildberry\JMSFormat\Attribute;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait VideoSrcAttributeTrait
{
    /**
     * @var string
     */
    protected $videoSrc;

    /**
     * @return string
     */
    public function getVideosrc()
    {
        return $this->videoSrc;
    }

    /**
     * @param string $videoSrc
     *
     * @return $this
     */
    public function setVideoSrc($videoSrc)
    {
        $this->videoSrc = $videoSrc;

        return $this;
    }
}
