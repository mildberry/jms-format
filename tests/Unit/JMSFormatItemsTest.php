<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Block\JMSBlockQuoteCollectionBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSHeadLineCollectionBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSParagraphCollectionBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\Exception\BadBlockTypeForAddToCollection;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatItemsTest extends PHPUnit_Framework_TestCase
{
    public function testFiledBlockQuoteItem()
    {
        $this->setExpectedException(BadBlockTypeForAddToCollection::class);
        $item = new JMSBlockQuoteCollectionBlock();
        $item->addBlock(new JMSHeadLineCollectionBlock());
    }

    public function testSuccessBlockQuoteItem()
    {
        $item = new JMSBlockQuoteCollectionBlock();
        $item->addBlock((new JMSImageBlock()));
        $item->addBlock((new JMSTextBlock('c')));
        $this->assertEquals('{"block":"blockquote","modifiers":[],"content":[{"block":"image","modifiers":[]},{"block":"text","modifiers":[],"content":"c"}]}', $item->asJMSText());
    }

    public function testFiledHeadLineItem()
    {
        $this->setExpectedException(BadBlockTypeForAddToCollection::class);
        $item = new JMSHeadLineCollectionBlock();
        $item->addBlock(new JMSParagraphCollectionBlock());
    }

    public function testSuccessHeadLineItem()
    {
        $item = new JMSHeadLineCollectionBlock();
        $item->setWeight('xs');
        $item->addBlock((new JMSTextBlock('c')));
        $this->assertEquals('{"block":"headline","modifiers":{"weight":"xs"},"content":[{"block":"text","modifiers":[],"content":"c"}]}', $item->asJMSText());
    }

    public function testSuccessImageItem()
    {
        $item = new JMSImageBlock();
        $item->setFloating('left');
        $item->setSize('wide');
        $item->setSrc('https://www.ya.ru/favicon.ico');
        $this->assertEquals('{"block":"image","modifiers":{"floating":"left","size":"wide","src":"https://www.ya.ru/favicon.ico"}}', $item->asJMSText());
    }

    public function testFiledParagraphItem()
    {
        $this->setExpectedException(BadBlockTypeForAddToCollection::class);
        $item = new JMSParagraphCollectionBlock();
        $item->addBlock(new JMSHeadLineCollectionBlock());
    }

    public function testSuccessParagraphItem()
    {
        $item = new JMSParagraphCollectionBlock();
        $item->setAlignment('center');
        $item->addBlock((new JMSImageBlock()));
        $item->addBlock((new JMSTextBlock('c')));
        $this->assertTrue(true);

        $collection = new JMSCollectionBlock();
        $collection->addBlock(new JMSTextBlock('c'));
        $item->addCollection($collection);

        $this->assertEquals('{"block":"paragraph","modifiers":{"alignment":"center"},"content":[{"block":"image","modifiers":[]},{"block":"text","modifiers":[],"content":"c"},{"block":"text","modifiers":[],"content":"c"}]}', $item->asJMSText());
    }

    public function testSuccessTextItem()
    {
        $item = new JMSTextBlock();
        $item->setContent('content');
        $item->setColor('info');
        $item->setDecoration('bold');
        $this->assertEquals('{"block":"text","modifiers":{"color":"info","decoration":["bold"]},"content":"content"}', $item->asJMSText());
    }
}
