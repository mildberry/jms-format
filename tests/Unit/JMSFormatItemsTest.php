<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Exception;
use Mildberry\JMSFormat\Block\BlockQuoteBlock;
use Mildberry\JMSFormat\Block\HeadLineItem;
use Mildberry\JMSFormat\Block\ImageBlock;
use Mildberry\JMSFormat\Block\ParagraphBlock;
use Mildberry\JMSFormat\Block\TextItem;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatItemsTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessBlockQuoteItem()
    {
        $item = new BlockQuoteBlock();
        try {
            $this->assertTrue(true);
            $item->push((new ImageBlock()));
            $item->push((new TextItem('c')));
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"blockquote","modifiers":[],"content":[{"block":"image","modifiers":[]},{"block":"text","modifiers":[],"content":"c"}]}', $item->asJMSText());
    }

    public function testSuccessHeadLineItem()
    {
        $item = new HeadLineItem();
        try {
            $item->setWeight('xs');
            $item->push((new TextItem('c')));
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"headline","modifiers":{"weight":"xs"},"content":[{"block":"text","modifiers":[],"content":"c"}]}', $item->asJMSText());
    }

    public function testSuccessImageItem()
    {
        $item = new ImageBlock();
        try {
            $item->setFloating('left');
            $item->setSize('wide');
            $item->setSrc('https://www.ya.ru/favicon.ico');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"image","modifiers":{"floating":"left","size":"wide","src":"https:\/\/www.ya.ru\/favicon.ico"}}', $item->asJMSText());
    }

    public function testParagraphItem()
    {
        $item = new ParagraphBlock();
        try {
            $item->setAlignment('center');
            $item->push((new ImageBlock()));
            $item->push((new TextItem('c')));
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"paragraph","modifiers":{"alignment":"center"},"content":[{"block":"image","modifiers":[]},{"block":"text","modifiers":[],"content":"c"}]}', $item->asJMSText());
    }

    public function testSuccessTextItem()
    {
        $item = new TextItem();
        try {
            $item->setContent('content');
            $item->setColor('info');
            $item->setDecoration('bold');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"text","modifiers":{"color":"info","decoration":"bold"},"content":"content"}', $item->asJMSText());
    }
}
