<?php

namespace Mildberry\JMSFormat\Attribute;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait VideoIdAttributeTrait
{
    /**
     * @var string
     */
    protected $videoId;

    /**
     * @return string
     */
    public function getVideoid()
    {
        return $this->videoId;
    }

    /**
     * @param string $videoId
     *
     * @return $this
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;

        return $this;
    }
}
