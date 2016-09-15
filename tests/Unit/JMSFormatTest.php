<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\JMSFormat;
use Mildberry\JMSFormat\Exception\BadParserNameException;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessConstruct()
    {
        $contentFormatter = $this->createFormatter();
        $this->assertTrue(($contentFormatter instanceof JMSFormat));
    }

    public function testFailedConvertFromHtmlToJson()
    {
        $contentFormatter = $this->createFormatter();
        try {
            $contentFormatter->convert('wrongFormat1', 'wrongFormat2', $this->getHtmlText());
            $this->assertTrue(false);
        } catch (BadParserNameException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessConvertFromHtmlToJson()
    {
        $contentFormatter = $this->createFormatter();
        $this->assertEquals('{"version":"v1","content":[{"block":"headline","modifiers":{"weight":"lg"},"content":[{"block":"text","modifiers":[],"content":"Header "},{"block":"text","modifiers":{"decoration":"italic"},"content":"1"}]},{"block":"paragraph","modifiers":[],"content":[{"block":"text","modifiers":[],"content":" Paragraph "},{"block":"text","modifiers":{"decoration":"bold"},"content":"1"},{"block":"text","modifiers":[],"content":"Span text!!!"},{"block":"image","modifiers":{"src":"https:\/\/www.ya.ru\/favicon.ico"}}]},{"block":"headline","modifiers":{"weight":"md"},"content":[{"block":"text","modifiers":[],"content":"Next header"}]},{"block":"blockquote","modifiers":[],"content":[{"block":"text","modifiers":[],"content":"Block quote text"}]}]}', $contentFormatter->convert('html', 'JMS', $this->getHtmlText()));
    }

    /**
     * @return JMSFormat
     */
    private function createFormatter()
    {
        return new JMSFormat();
    }

    /**
     * @return string
     */
    private function getHtmlText()
    {
        return '<h1>Header <i>1</i></h1><p> Paragraph <b>1</b> <span>Span text!!!</span> <img src="https://www.ya.ru/favicon.ico"></p><h2>Next header</h2><blockquote>Block quote text</blockquote>';
    }
}
