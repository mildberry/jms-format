<?php

namespace Mildberry\JMSFormat;

use Mildberry\JMSFormat\Exception\BadParserNameException;
use Mildberry\JMSFormat\Interfaces\ParserInterface;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormat
{
    /**
     * @var JMSCollectionBlock
     */
    private $data;

    /**
     * @param string $formatName
     * @param string $content
     * @return $this
     */
    public function loadFormFormat($formatName, $content)
    {
        $this->data = $this->convertToCollection($formatName, $content);

        return $this;
    }

    /**
     * @param $formatName
     * @return string
     */
    public function saveToFormat($formatName)
    {
        return $this->convertToContent($formatName, $this->data);
    }

    /**
     * @return JMSCollectionBlock
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param JMSCollectionBlock $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $fromFormat
     * @param string $toFormat
     * @param string $content
     * @return string
     */
    public function convert($fromFormat, $toFormat, $content)
    {
        return $this->createParserFromFormatName($toFormat)->toContent($this->createParserFromFormatName($fromFormat)->toCollection($content));
    }

    /**
     * @param string $fromFormat
     * @param string $content
     * @return JMSCollectionBlock
     * @throws BadParserNameException
     */
    public function convertToCollection($fromFormat, $content)
    {
        return $this->createParserFromFormatName($fromFormat)->toCollection($content);
    }

    /**
     * @param $toFormat
     * @param JMSCollectionBlock $collection
     * @return string
     * @throws BadParserNameException
     */
    public function convertToContent($toFormat, JMSCollectionBlock $collection)
    {
        return $this->createParserFromFormatName($toFormat)->toContent($collection);
    }

    /**
     * @param string $name
     * @return ParserInterface
     * @throws BadParserNameException
     */
    private function createParserFromFormatName($name)
    {
        $formatName = $this->getFormatClassByName($name);

        if (!class_exists($formatName)) {
            throw new BadParserNameException('Parser class for format '.$name.' not found.');
        }

        $format = new $formatName;

        if (!$format instanceof ParserInterface) {
            throw new BadParserNameException('Handler for format '.$name.' not found.');
        }

        return $format;
    }

    /**
     * @param string $name
     * @return string
     */
    private function getFormatClassByName($name)
    {
        return 'Mildberry\\JMSFormat\\Parser\\'.ucfirst(strtolower($name)).'Parser';
    }
}
