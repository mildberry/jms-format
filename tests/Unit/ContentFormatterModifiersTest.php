<?php

namespace Mildberry\Library\ContentFormatter\Test\Unit;

use Mildberry\Library\ContentFormatter\Exception\WrongModifierValueException;
use Mildberry\Library\ContentFormatter\Item\HeadLineItem;
use Mildberry\Library\ContentFormatter\Item\ImageItem;
use Mildberry\Library\ContentFormatter\Item\ParagraphItem;
use Mildberry\Library\ContentFormatter\Item\TextItem;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class ContentFormatterModifiersTest extends PHPUnit_Framework_TestCase
{
    public function testFiledAlignmentModifier()
    {
        $item = new ParagraphItem();
        try {
            $item->setAlignment('tam');
            $this->assertTrue(false);
        } catch (WrongModifierValueException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessAlignmentModifier()
    {
        $item = new ParagraphItem();
        try {
            $item->setAlignment('left');
            $item->setAlignment('center');
            $item->setAlignment('right');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals(3, count($item->getAlignmentAllowedValues()));
    }

    public function testFiledColorModifier()
    {
        $item = new TextItem('context');
        try {
            $item->setColor('baclajane');
            $this->assertTrue(false);
        } catch (WrongModifierValueException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessColorModifier()
    {
        $item = new TextItem('context');
        try {
            $item->setColor('muted');
            $item->setColor('success');
            $item->setColor('info');
            $item->setColor('warning');
            $item->setColor('danger');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals(5, count($item->getColorAllowedValues()));
    }

    public function testFiledFloatingModifier()
    {
        $item = new ImageItem();
        try {
            $item->setFloating('tut');
            $this->assertTrue(false);
        } catch (WrongModifierValueException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessFloatingModifier()
    {
        $item = new ImageItem();
        try {
            $item->setFloating('left');
            $item->setFloating('right');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals(2, count($item->getFloatingAllowedValues()));
    }

    public function testFiledSizeModifier()
    {
        $item = new ImageItem();
        try {
            $item->setSize('super mega big');
            $this->assertTrue(false);
        } catch (WrongModifierValueException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessSizeModifier()
    {
        $item = new ImageItem();
        try {
            $item->setSize('wide');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals(1, count($item->getSizeAllowedValues()));
    }

    public function testFiledWeightModifier()
    {
        $item = new HeadLineItem('');
        try {
            $item->setWeight('uaaaH!!!');
            $this->assertTrue(false);
        } catch (WrongModifierValueException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessWeightModifier()
    {
        $item = new HeadLineItem('');
        try {
            $item->setWeight('h1');
            $item->setWeight('h2');
            $item->setWeight('h3');
            $item->setWeight('h4');
            $item->setWeight('h5');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals(5, count($item->getWeightAllowedValues()));
    }
}
