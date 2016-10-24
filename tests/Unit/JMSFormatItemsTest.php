<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSBlockquoteBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSHeadlineBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSParagraphBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\Block\JMSVideoBlock;
use Mildberry\JMSFormat\Exception\BadBlockTypeForAddToCollection;
use Mildberry\JMSFormat\Parser\JmsParser;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatItemsTest extends PHPUnit_Framework_TestCase
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

    public function testFiledBlockQuoteItem()
    {
        $this->setExpectedException(BadBlockTypeForAddToCollection::class);
        $item = new JMSBlockquoteBlock();
        $item->addBlock(new JMSHeadlineBlock());
    }

    public function testSuccessBlockQuoteItem()
    {
        $item = new JMSBlockquoteBlock();
        $item->addBlock((new JMSImageBlock()));
        $item->addBlock((new JMSTextBlock('c')));
        $this->assertEquals('{"version":"v1","content":[{"block":"blockquote","modifiers":[],"content":[{"block":"image","modifiers":[]},{"block":"text","modifiers":[],"content":"c"}]}]}', $this->asText($item));
    }

    public function testFiledHeadLineItem()
    {
        $this->setExpectedException(BadBlockTypeForAddToCollection::class);
        $item = new JMSHeadlineBlock();
        $item->addBlock(new JMSParagraphBlock());
    }

    public function testSuccessHeadLineItem()
    {
        $item = new JMSHeadlineBlock();
        $item->setWeight('xs');
        $item->addBlock((new JMSTextBlock('c')));
        $this->assertEquals('{"version":"v1","content":[{"block":"headline","modifiers":{"weight":"xs"},"content":[{"block":"text","modifiers":[],"content":"c"}]}]}', $this->asText($item));
    }

    public function testSuccessImageItem()
    {
        $item = new JMSImageBlock();
        $item->setFloating('left');
        $item->setSize('wide');
        $item->setSrc('https://www.ya.ru/favicon.ico');
        $this->assertEquals('{"version":"v1","content":[{"block":"image","modifiers":{"floating":"left","size":"wide"},"attributes":{"src":"https://www.ya.ru/favicon.ico"}}]}', $this->asText($item));
    }

    public function testFiledParagraphItem()
    {
        $this->setExpectedException(BadBlockTypeForAddToCollection::class);
        $item = new JMSParagraphBlock();
        $item->addBlock(new JMSHeadlineBlock());
    }

    public function testSuccessParagraphItem()
    {
        $item = new JMSParagraphBlock();
        $item->setAlignment('center');
        $item->addBlock((new JMSImageBlock()));
        $item->addBlock((new JMSTextBlock('c')));
        $this->assertTrue(true);

        $collection = new JMSCollectionBlock();
        $collection->addBlock(new JMSTextBlock('c'));
        $item->addCollection($collection);

        $this->assertEquals('{"version":"v1","content":[{"block":"paragraph","modifiers":{"alignment":"center"},"content":[{"block":"image","modifiers":[]},{"block":"text","modifiers":[],"content":"c"},{"block":"text","modifiers":[],"content":"c"}]}]}', $this->asText($item));
    }

    public function testSuccessTextItem()
    {
        $item = new JMSTextBlock();
        $item->setContent('content');
        $item->setColor('info');
        $item->setDecoration('bold');
        $this->assertEquals('{"version":"v1","content":[{"block":"text","modifiers":{"color":"info","decoration":["bold"]},"content":"content"}]}', $this->asText($item));
    }

    public function testSuccessVideoBlock()
    {
        $item = (new JMSVideoBlock())
            ->setVideoSrc('https://www.youtube.com/video/1')
            ->setVideoProvider('youtube')
            ->setVideoId('1')
            ->setFloating('left')
            ->setSize('wide')
        ;

        $this->assertEquals('{"version":"v1","content":[{"block":"video","modifiers":{"floating":"left","size":"wide"},"attributes":{"videoSrc":"https://www.youtube.com/video/1","videoId":"1","videoProvider":"youtube"}}]}', $this->asText($item));
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
