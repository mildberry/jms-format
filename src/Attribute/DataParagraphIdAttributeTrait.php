<?php

namespace Mildberry\JMSFormat\Attribute;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait DataParagraphIdAttributeTrait
{
    /**
     * @var string
     */
    protected $dataParagraphId;

    /**
     * @return string
     */
    public function getDataParagraphId()
    {
        return $this->dataParagraphId;
    }

    /**
     * @param string $dataParagraphId
     *
     * @return $this
     */
    public function setDataParagraphId($dataParagraphId)
    {
        $this->dataParagraphId = $dataParagraphId;

        return $this;
    }
}
