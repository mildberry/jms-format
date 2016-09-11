<?php

namespace Mildberry\Library\ContentFormatter\Test\Unit;

use Mildberry\Library\ContentFormatter\ContentFormatter;
use Mildberry\Library\ContentFormatter\Exception\WrongFormatNameException;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class ContentFormatterTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessConstruct()
    {
        $contentFormatter = $this->createContentFormatter();
        $this->assertTrue(($contentFormatter instanceof ContentFormatter));
    }

    public function testFailedConvertFromHtmlToJson()
    {
        $contentFormatter = $this->createContentFormatter();
        try {
            $contentFormatter->convert('wrongFormat1', 'wrongFormat2', '<html></html>');
            $this->assertTrue(false);
        } catch (WrongFormatNameException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessConvertFromHtmlToJson()
    {
        $contentFormatter = $this->createContentFormatter();
        $this->assertEquals('', $contentFormatter->convert('html', 'json', '<html></html>'));
    }

    /**
     * @return ContentFormatter
     */
    private function createContentFormatter()
    {
        return new ContentFormatter();
    }
}
