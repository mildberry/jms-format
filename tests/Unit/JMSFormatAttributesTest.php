<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Exception\BadModifierValueException;
use Mildberry\JMSFormat\Block\JMSParagraphBlock;
use Mildberry\JMSFormat\Block\JMSHeadlineBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\JMSAttributeHelper;
use Mildberry\JMSFormat\JMSModifierHelper;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatAttributesTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessAttributeHelper()
    {
        $this->assertEquals(['src', 'data-paragraph-id'], JMSAttributeHelper::getAllowedAttributes());
        $this->assertEquals('Mildberry\JMSFormat\Interfaces\DataParagraphIdAttributeInterface', JMSAttributeHelper::getAttributeInterfaceClassName('data-paragraph-id'));
    }

    public function testSuccessSrcAttribute()
    {
        $item = new JMSImageBlock();
        $item->setSrc('http://www.ya.ru');
        $this->assertEquals('{"block":"image","modifiers":[],"attributes":{"src":"http://www.ya.ru"}}', $item->getJMSText());
        $this->assertEquals('<img src="http://www.ya.ru">', $item->getHTMLText());
    }

    public function testSuccessDataParagraphIdAttribute()
    {
        $item = new JMSParagraphBlock();
        $item->setDataParagraphId("1");
        $this->assertEquals('{"block":"paragraph","modifiers":[],"attributes":{"data-paragraph-id":"1"},"content":[]}', $item->getJMSText());
        $this->assertEquals('<p data-paragraph-id="1"></p>', $item->getHTMLText());
    }
}
