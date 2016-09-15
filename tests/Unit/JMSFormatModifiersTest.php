<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Exception\BadModifierValueException;
use Mildberry\JMSFormat\Block\JMSParagraphCollectionBlock;
use Mildberry\JMSFormat\Block\JMSHeadLineCollectionBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatModifiersTest extends PHPUnit_Framework_TestCase
{
    public function testFiledAlignmentModifier()
    {
        $item = new JMSParagraphCollectionBlock();
        try {
            $item->setAlignment('tam');
            $this->assertTrue(false);
        } catch (BadModifierValueException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessAlignmentModifier()
    {
        $item = new JMSParagraphCollectionBlock();
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
        $item = new JMSTextBlock('context');
        try {
            $item->setColor('baclajane');
            $this->assertTrue(false);
        } catch (BadModifierValueException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessColorModifier()
    {
        $item = new JMSTextBlock('context');
        try {
            $item->setColor('muted');
            $item->setColor('success');
            $item->setColor('info');
            $item->setColor('warning');
            $item->setColor('danger');
            $item->setDecoration('bold');
            $item->setDecoration('italic');
            $item->setDecoration('del');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals(5, count($item->getColorAllowedValues()));
        $this->assertEquals(3, count($item->getDecorationAllowedValues()));
    }

    public function testFiledFloatingModifier()
    {
        $item = new JMSImageBlock();
        try {
            $item->setFloating('tut');
            $this->assertTrue(false);
        } catch (BadModifierValueException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessFloatingModifier()
    {
        $item = new JMSImageBlock();
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
        $item = new JMSImageBlock();
        try {
            $item->setSize('super mega big');
            $this->assertTrue(false);
        } catch (BadModifierValueException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessSizeModifier()
    {
        $item = new JMSImageBlock();
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
        $item = new JMSHeadLineCollectionBlock('');
        try {
            $item->setWeight('uaaaH!!!');
            $this->assertTrue(false);
        } catch (BadModifierValueException $e) {
            $this->assertTrue(true);
        }
    }

    public function testSuccessWeightModifier()
    {
        $item = new JMSHeadLineCollectionBlock('');
        try {
            $item->setWeight('xs');
            $item->setWeight('sm');
            $item->setWeight('md');
            $item->setWeight('lg');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
        $this->assertEquals(4, count($item->getWeightAllowedValues()));
    }
}
