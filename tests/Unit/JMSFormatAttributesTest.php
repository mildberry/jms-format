<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSParagraphBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\JMSAttributeHelper;
use Mildberry\JMSFormat\Parser\HtmlParser;
use Mildberry\JMSFormat\Parser\JmsParser;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatAttributesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var JmsParser
     */
    protected $jmsParser;

    /**
     * @var HtmlParser
     */
    protected $htmlParser;

    public function __construct()
    {
        parent::__construct();

        $this->jmsParser = new JmsParser();
        $this->htmlParser = new HtmlParser();
    }

    public function testSuccessAttributeHelper()
    {
        $this->assertEquals(['src', 'paragraphId'], JMSAttributeHelper::getAllowedAttributes());
        $this->assertEquals('Mildberry\JMSFormat\Interfaces\ParagraphidAttributeInterface', JMSAttributeHelper::getAttributeInterfaceClassName('paragraphId'));
    }

    public function testSuccessSrcAttribute()
    {
        $item = new JMSImageBlock();
        $item->setSrc('http://www.ya.ru');
        $this->assertEquals('{"version":"v1","content":[{"block":"image","modifiers":[],"attributes":{"src":"http://www.ya.ru"}}]}', $this->asJmsText($item));
        $this->assertEquals('<img src="http://www.ya.ru">', $this->asHtmlText($item));
    }

    public function testSuccessDataParagraphIdAttribute()
    {
        $item = new JMSParagraphBlock();
        $item->setParagraphId("1");
        $this->assertEquals('{"version":"v1","content":[{"block":"paragraph","modifiers":[],"attributes":{"paragraphId":"1"}}]}', $this->asJmsText($item));
        $this->assertEquals('<p data-paragraph-id="1"></p>', $this->asHtmlText($item));
    }

    /**
     * @param JMSAbstractBlock $item
     * @return string
     */
    private function asJmsText($item)
    {
        return $this->jmsParser->toContent((new JMSCollectionBlock())->addBlock($item));
    }

    private function asHtmlText($item)
    {
        return $this->htmlParser->toContent((new JMSCollectionBlock())->addBlock($item));
    }

}
