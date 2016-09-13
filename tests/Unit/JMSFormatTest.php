<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\JMSFormat;
use Mildberry\JMSFormat\Exception\WrongFormatNameException;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessConstruct()
    {
        $contentFormatter = $this->createJMSFormat();
        $this->assertTrue(($contentFormatter instanceof JMSFormat));
    }

    public function testFailedConvertFromHtmlToJson()
    {
        $contentFormatter = $this->createJMSFormat();
        try {
            $contentFormatter->convert('wrongFormat1', 'wrongFormat2', '<html></html>');
            $this->assertTrue(false);
        } catch (WrongFormatNameException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessConvertFromHtmlToJson()
    {
        $contentFormatter = $this->createJMSFormat();
        $this->assertEquals('{"version":"v1","content":[]}', $contentFormatter->convert('html', 'json', '<html></html>'));
    }

    /**
     * @return JMSFormat
     */
    private function createJMSFormat()
    {
        return new JMSFormat();
    }
}
