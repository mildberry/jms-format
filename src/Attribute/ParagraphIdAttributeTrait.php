<?php

namespace Mildberry\JMSFormat\Attribute;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait ParagraphIdAttributeTrait
{
    /**
     * @var string
     */
    protected $paragraphId;

    /**
     * @return string
     */
    public function getParagraphid()
    {
        return $this->paragraphId;
    }

    /**
     * @param string $paragraphId
     *
     * @return $this
     */
    public function setParagraphId($paragraphId)
    {
        $this->paragraphId = $paragraphId;

        return $this;
    }
}
