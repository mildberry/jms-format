<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Exception;
use Mildberry\JMSFormat\Block\JMSBlockQuoteCollectionBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSHeadLineCollectionBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSParagraphCollectionBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatItemsTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessBlockQuoteItem()
    {
        $item = new JMSBlockQuoteCollectionBlock();
        try {
            $this->assertTrue(true);
            $item->addBlock((new JMSImageBlock()));
            $item->addBlock((new JMSTextBlock('c')));
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"blockquote","modifiers":[],"content":[{"block":"image","modifiers":[]},{"block":"text","modifiers":[],"content":"c"}]}', $item->asJMSText());
    }

    public function testSuccessHeadLineItem()
    {
        $item = new JMSHeadLineCollectionBlock();
        try {
            $item->setWeight('xs');
            $item->addBlock((new JMSTextBlock('c')));
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"headline","modifiers":{"weight":"xs"},"content":[{"block":"text","modifiers":[],"content":"c"}]}', $item->asJMSText());
    }

    public function testSuccessImageItem()
    {
        $item = new JMSImageBlock();
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
        $item = new JMSParagraphCollectionBlock();
        try {
            $item->setAlignment('center');
            $item->addBlock((new JMSImageBlock()));
            $item->addBlock((new JMSTextBlock('c')));
            $this->assertTrue(true);

            $collection = new JMSCollectionBlock();
            $collection->addBlock(new JMSTextBlock('c'));
            $item->addCollection($collection);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"paragraph","modifiers":{"alignment":"center"},"content":[{"block":"image","modifiers":[]},{"block":"text","modifiers":[],"content":"c"},{"block":"text","modifiers":[],"content":"c"}]}', $item->asJMSText());
    }

    public function testSuccessTextItem()
    {
        $item = new JMSTextBlock();
        try {
            $item->setContent('content');
            $item->setColor('info');
            $item->setDecoration('bold');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals('{"block":"text","modifiers":{"color":"info","decoration":["bold"]},"content":"content"}', $item->asJMSText());
    }
}
