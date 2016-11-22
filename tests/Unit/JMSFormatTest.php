<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Interfaces\ParserInterface;
use Mildberry\JMSFormat\JMSFormat;
use Mildberry\JMSFormat\Exception\BadParserNameException;
use Mildberry\JMSFormat\Parser\HtmlParser;
use Mildberry\JMSFormat\Parser\JmsParser;
use Mildberry\JMSFormat\Tests\TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatTest extends TestCase
{
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
        $this->assertEquals('{"version":"v1","content":[{"block":"body","modifiers":[]}]}', $this->asJmsText($contentFormatter->getData()));

        $this->assertEquals($this->getJMSText(), $contentFormatter->loadFormFormat('JMS', $this->getJMSText())->saveToFormat('JMS'));
        $this->assertEquals($this->getHtmlText(), $contentFormatter->loadFormFormat('JMS', $this->getJMSText())->saveToFormat('Html'));
    }

    public function testSuccessJMSParser()
    {
        $parser = new JmsParser();
        $this->assertTrue($parser instanceof ParserInterface);
        $this->assertEquals('{"version":"v1","content":[{"block":"body","modifiers":[]}]}', $this->asJmsText($parser->toCollection('')));
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
        return file_get_contents(__DIR__.'/../Data/data.html');
    }

    /**
     * @return string
     */
    private function getJMSText()
    {
        return file_get_contents(__DIR__.'/../Data/data.json');
    }
}
