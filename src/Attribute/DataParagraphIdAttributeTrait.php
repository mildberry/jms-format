<?php

namespace Mildberry\JMSFormat\Attribute;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait DataParagraphIdAttributeTrait
{
    /**
     * @var int
     */
    private $dataParagraphId;

    /**
     * @return int
     */
    public function getDataParagraphId()
    {
        return $this->dataParagraphId;
    }

    /**
     * @param int $dataParagraphId
     *
     * @return $this
     */
    public function setDataParagraphId($dataParagraphId)
    {
        $this->dataParagraphId = $dataParagraphId;

        return $this;
    }
}
