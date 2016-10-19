<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSParagraphBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\JMSAttributeHelper;
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
    protected $jms;

    public function __construct()
    {
        parent::__construct();

        $this->jms = new JmsParser();
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
        $this->assertEquals('{"version":"v1","content":[{"block":"image","modifiers":[],"attributes":{"src":"http://www.ya.ru"}}]}', $this->asText($item));
        $this->assertEquals('<img src="http://www.ya.ru">', $item->getHTMLText());
    }

    public function testSuccessDataParagraphIdAttribute()
    {
        $item = new JMSParagraphBlock();
        $item->setParagraphId("1");
        $this->assertEquals('{"version":"v1","content":[{"block":"paragraph","modifiers":[],"attributes":{"paragraphId":"1"}}]}', $this->asText($item));
        $this->assertEquals('<p data-paragraph-id="1"></p>', $item->getHTMLText());
    }

    /**
     * @param JMSAbstractBlock $item
     * @return string
     */
    private function asText($item)
    {
        return $this->jms->toContent((new JMSCollectionBlock())->addBlock($item));
    }
}
