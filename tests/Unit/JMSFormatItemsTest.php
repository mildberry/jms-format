<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Exception;
use Mildberry\JMSFormat\Item\BlockQuoteItem;
use Mildberry\JMSFormat\Item\HeadLineItem;
use Mildberry\JMSFormat\Item\ImageItem;
use Mildberry\JMSFormat\Item\ParagraphItem;
use Mildberry\JMSFormat\Item\TextItem;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatItemsTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessBlockQuoteItem()
    {
        $item = new BlockQuoteItem();
        try {
            $item->setContent('content');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"blockquote","modifiers":[],"content":"content"}', $item->asJMSText());
    }

    public function testSuccessHeadLineItem()
    {
        $item = new HeadLineItem();
        try {
            $item->setContent('content');
            $item->setWeight('h1');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"headline","modifiers":{"weight":"h1"},"content":"content"}', $item->asJMSText());
    }

    public function testSuccessImageItem()
    {
        $item = new ImageItem();
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
        $item = new ParagraphItem();
        try {
            $item->setAlignment('center');
            $item->push((new BlockQuoteItem('c')));
            $item->push((new HeadLineItem('c')));
            $item->push((new ImageItem()));
            $item->push((new TextItem('c')));
            $item->push((new ParagraphItem('c')));
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"paragraph","modifiers":{"alignment":"center"},"content":[{"block":"blockquote","modifiers":[],"content":"c"},{"block":"headline","modifiers":[],"content":"c"},{"block":"image","modifiers":[]},{"block":"text","modifiers":[],"content":"c"},{"block":"paragraph","modifiers":[],"content":"c"}]}', $item->asJMSText());
    }

    public function testSuccessTextItem()
    {
        $item = new TextItem();
        try {
            $item->setContent('content');
            $item->setColor('info');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"text","modifiers":{"color":"info"},"content":"content"}', $item->asJMSText());
    }
}
