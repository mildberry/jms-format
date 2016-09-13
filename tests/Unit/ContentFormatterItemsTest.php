<?php

namespace Mildberry\Library\ContentFormatter\Test\Unit;

use Mildberry\Library\ContentFormatter\Item\BlockQuoteItem;
use Mildberry\Library\ContentFormatter\Item\CollectionItem;
use Mildberry\Library\ContentFormatter\Item\HeadLineItem;
use Mildberry\Library\ContentFormatter\Item\ImageItem;
use Mildberry\Library\ContentFormatter\Item\ParagraphItem;
use Mildberry\Library\ContentFormatter\Item\TextItem;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class ContentFormatterItemsTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessBlockQuoteItem()
    {
        $item = new BlockQuoteItem();
        try {
            $item->setContent('content');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }

    public function testSuccessCollectionItem()
    {
        $item = new CollectionItem();
        try {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }

    public function testSuccessHeadLineItem()
    {
        $item = new HeadLineItem();
        try {
            $item->setContent('content');
            $item->setWeight('h1');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }

    public function testSuccessImageItem()
    {
        $item = new ImageItem();
        try {
            $item->setFloating('left');
            $item->setSize('wide');
            $item->setSrc('https://www.ya.ru/favicon.ico');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }

    public function testParagraphItem()
    {
        $item = new ParagraphItem();
        try {
            $item->setAlignment('center');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }

    public function testSuccessTextItem()
    {
        $item = new TextItem();
        try {
            $item->setContent('content');
            $item->setColor('info');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }
}
