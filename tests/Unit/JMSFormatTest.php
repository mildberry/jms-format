<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Interfaces\ParserInterface;
use Mildberry\JMSFormat\JMSFormat;
use Mildberry\JMSFormat\Exception\BadParserNameException;
use Mildberry\JMSFormat\Parser\HtmlParser;
use Mildberry\JMSFormat\Parser\JmsParser;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var JmsParser
     */
    protected $jms;

    public function __construct()
    {
        parent::__construct();

        $this->jms = new JmsParser();
    }

    public function testSuccessConstruct()
    {
        $contentFormatter = $this->createFormatter();
        $this->assertTrue(($contentFormatter instanceof JMSFormat));
    }

    public function testFailedConvertFromHtmlToJson()
    {
        $this->setExpectedException(BadParserNameException::class);
        $contentFormatter = $this->createFormatter();
        $contentFormatter->convert('Test', 'JMS', $this->getHtmlText());
    }

    public function testFailedConvert2FromHtmlToJson()
    {
        $this->setExpectedException(BadParserNameException::class);
        $contentFormatter = $this->createFormatter();
        $contentFormatter->convert('Wrong', 'JMS', $this->getHtmlText());
    }

    public function testSuccessConvertFromHtmlToJson()
    {
        $contentFormatter = $this->createFormatter();
        $this->assertEquals($this->getJMSText(), $contentFormatter->convert('html', 'JMS', $this->getHtmlText()));

        $contentFormatter->setData(new JMSCollectionBlock());
        $this->assertEquals('{"version":"v1","content":[]}', $this->asText($contentFormatter->getData()));

        $this->assertEquals($this->getJMSText(), $contentFormatter->loadFormFormat('JMS', $this->getJMSText())->saveToFormat('JMS'));
        $this->assertEquals($this->getHtmlText(), $contentFormatter->loadFormFormat('JMS', $this->getJMSText())->saveToFormat('Html'));
    }

    public function testSuccessJMSParser()
    {
        $parser = new JmsParser();
        $this->assertTrue($parser instanceof ParserInterface);
        $this->assertEquals('{"version":"v1","content":[]}', $this->asText($parser->toCollection('')));
    }

    public function testSuccessHTMLParser()
    {
        $parser = new HtmlParser();
        $this->assertTrue($parser instanceof ParserInterface);
        $this->assertEquals('', $parser->toContent(new JMSCollectionBlock()));
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
        return '<h1>Header <i class="decoration-bold">1</i></h1><p class="alignment-left" data-paragraph-id="1">Paragraph <b class="color-danger">BOLD</b> text inside tag <b class="decoration-italic">BOLD AND ITALIC</b><i class="decoration-bold"> ITALIC AND BOLD </i><img class="size-wide" src="https://www.ya.ru/favicon.ico"></p><h2>Next header</h2><blockquote>Block <u>quote</u> <del>text</del><object class="floating-left size-wide" data-video-src="https://www.youtube.com/video/1" data-video-id="1" data-video-provider="youtube"><embed /></object></blockquote>';
    }

    private function getJMSText()
    {
        return '{"version":"v1","content":[{"block":"headline","modifiers":{"weight":"lg"},"content":[{"block":"text","modifiers":[],"content":"Header "},{"block":"text","modifiers":{"decoration":["italic","bold"]},"content":"1"}]},{"block":"paragraph","modifiers":{"alignment":"left"},"attributes":{"paragraphId":"1"},"content":[{"block":"text","modifiers":[],"content":"Paragraph "},{"block":"text","modifiers":{"color":"danger","decoration":["bold"]},"content":"BOLD"},{"block":"text","modifiers":[],"content":" text inside tag "},{"block":"text","modifiers":{"decoration":["bold","italic"]},"content":"BOLD AND ITALIC"},{"block":"text","modifiers":{"decoration":["italic","bold"]},"content":" ITALIC AND BOLD "},{"block":"image","modifiers":{"size":"wide"},"attributes":{"src":"https://www.ya.ru/favicon.ico"}}]},{"block":"headline","modifiers":{"weight":"md"},"content":[{"block":"text","modifiers":[],"content":"Next header"}]},{"block":"blockquote","modifiers":[],"content":[{"block":"text","modifiers":[],"content":"Block "},{"block":"text","modifiers":{"decoration":["underline"]},"content":"quote"},{"block":"text","modifiers":[],"content":" "},{"block":"text","modifiers":{"decoration":["del"]},"content":"text"},{"block":"video","modifiers":{"floating":"left","size":"wide"},"attributes":{"videoSrc":"https://www.youtube.com/video/1","videoId":"1","videoProvider":"youtube"}}]}]}';
    }

    /**
     * @param JMSCollectionBlock $item
     * @return string
     */
    private function asText($item)
    {
        return $this->jms->toContent($item);
    }
}
