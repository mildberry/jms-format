<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Formatter;
use Mildberry\JMSFormat\Exception\WrongFormatNameException;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessConstruct()
    {
        $contentFormatter = $this->createFormatter();
        $this->assertTrue(($contentFormatter instanceof Formatter));
    }

    public function testFailedConvertFromHtmlToJson()
    {
        $contentFormatter = $this->createFormatter();
        try {
            $contentFormatter->convert('wrongFormat1', 'wrongFormat2', '<html></html>');
            $this->assertTrue(false);
        } catch (WrongFormatNameException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessConvertFromHtmlToJson()
    {
        $contentFormatter = $this->createFormatter();
        $this->assertEquals('{"version":"v1","content":[]}', $contentFormatter->convert('html', 'json', '<html></html>'));
    }

    /**
     * @return Formatter
     */
    private function createFormatter()
    {
        return new Formatter();
    }
}
