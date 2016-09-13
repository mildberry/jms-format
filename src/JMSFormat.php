<?php

namespace Mildberry\JMSFormat;

use Mildberry\JMSFormat\Exception\WrongFormatNameException;
use Mildberry\JMSFormat\Format\FormatInterface;
use Mildberry\JMSFormat\Item\CollectionItem;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormat
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
     * @param CollectionItem $content
     * @return CollectionItem
     * @throws WrongFormatNameException
     */
    public function convertToCollection($fromFormat, $content)
    {
        return $this->createFormat($fromFormat)->toCollection($content);
    }

    /**
     * @param $toFormat
     * @param CollectionItem $collection
     * @return string
     * @throws WrongFormatNameException
     */
    public function convertToContent($toFormat, CollectionItem $collection)
    {
        return $this->createFormat($toFormat)->toContent($collection);
    }

    /**
     * @param string $name
     * @return FormatInterface
     * @throws WrongFormatNameException
     */
    private function createFormat($name)
    {
        $formatName = $this->getFormatClassByName($name);

        if (!class_exists($formatName)) {
            throw new WrongFormatNameException('Class '.$name.' format not found.');
        }

        $format = new $formatName;

        if (!$format instanceof FormatInterface) {
            throw new WrongFormatNameException('Handler for '.$name.' format not found.');
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
