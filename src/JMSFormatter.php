<?php

namespace Mildberry\JMSFormat;

use Mildberry\JMSFormat\Exception\BadFormatNameException;
use Mildberry\JMSFormat\Format\FormatInterface;
use Mildberry\JMSFormat\Block\CollectionBlock;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatter
{
    /**
     * @param string $fromFormat
     * @param string $toFormat
     * @param string $content
     * @return string
     */
    public function convert($fromFormat, $toFormat, $content)
    {
        return $this->createFormat($toFormat)->toContent($this->createFormat($fromFormat)->toCollection($content));
    }

    /**
     * @param string $fromFormat
     * @param CollectionBlock $content
     * @return CollectionBlock
     * @throws BadFormatNameException
     */
    public function convertToCollection($fromFormat, $content)
    {
        return $this->createFormat($fromFormat)->toCollection($content);
    }

    /**
     * @param $toFormat
     * @param CollectionBlock $collection
     * @return string
     * @throws BadFormatNameException
     */
    public function convertToContent($toFormat, CollectionBlock $collection)
    {
        return $this->createFormat($toFormat)->toContent($collection);
    }

    /**
     * @param string $name
     * @return FormatInterface
     * @throws BadFormatNameException
     */
    private function createFormat($name)
    {
        $formatName = $this->getFormatClassByName($name);

        if (!class_exists($formatName)) {
            throw new BadFormatNameException('Class '.$name.' format not found.');
        }

        $format = new $formatName;

        if (!$format instanceof FormatInterface) {
            throw new BadFormatNameException('Handler for '.$name.' format not found.');
        }

        return $format;
    }

    /**
     * @param string $name
     * @return string
     */
    private function getFormatClassByName($name)
    {
        return 'Mildberry\\JMSFormat\\Format\\'.ucfirst($name).'Format';
    }
}
