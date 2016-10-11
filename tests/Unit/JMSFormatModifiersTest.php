<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Exception\BadModifierValueException;
use Mildberry\JMSFormat\Block\JMSParagraphBlock;
use Mildberry\JMSFormat\Block\JMSHeadlineBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\JMSModifierHelper;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatModifiersTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessModifierHelper()
    {
        $this->assertEquals(['alignment', 'color', 'floating', 'size', 'weight', 'decoration'], JMSModifierHelper::getAllowedModifiers());
        $this->assertEquals('Mildberry\JMSFormat\Interfaces\ColorModifierInterface', JMSModifierHelper::getModifierInterfaceClassName('COLOR'));
        $this->assertEquals('getColor', JMSModifierHelper::getModifierGetterName('cOlOr'));
        $this->assertEquals('setColor', JMSModifierHelper::getModifierSetterName('cOlOr'));
    }

    public function testFiledAlignmentModifier()
    {
        $this->setExpectedException(BadModifierValueException::class);
        $item = new JMSParagraphBlock();
        $item->setAlignment('tam');
    }

    public function testSuccessAlignmentModifier()
    {
        $item = new JMSParagraphBlock();
        $item->setAlignment('left');
        $item->setAlignment('center');
        $item->setAlignment('right');
        $this->assertEquals(3, count($item->getAlignmentAllowedValues()));
        $this->assertEquals('{"block":"paragraph","modifiers":{"alignment":"right"},"content":[]}', $item->getJMSText());
    }

    public function testFiledColorModifier()
    {
        $this->setExpectedException(BadModifierValueException::class);
        $item = new JMSTextBlock('content');
        $item->setColor('baclajane');
    }

    public function testSuccessColorModifier()
    {
        $item = new JMSTextBlock('content');
        $item->setColor('muted');
        $item->setColor('success');
        $item->setColor('info');
        $item->setColor('warning');
        $item->setColor('danger');
        $this->assertEquals(5, count($item->getColorAllowedValues()));
        $this->assertEquals('{"block":"text","modifiers":{"color":"danger"},"content":"content"}', $item->getJMSText());
    }

    public function testFiledDecorationModifier()
    {
        $this->setExpectedException(BadModifierValueException::class);
        $item = new JMSTextBlock('content');
        $item->setDecoration('top');
    }

    public function testSuccessDecorationModifier()
    {
        $item = new JMSTextBlock('content');
        $item->setDecoration('bold');
        $item->setDecoration('italic');
        $item->setDecoration('del');
        $item->setDecoration('underline');
        $this->assertEquals(4, count($item->getDecorationAllowedValues()));
        $this->assertEquals('{"block":"text","modifiers":{"decoration":["bold","italic","del","underline"]},"content":"content"}', $item->getJMSText());
    }

    public function testFiledFloatingModifier()
    {
        $this->setExpectedException(BadModifierValueException::class);
        $item = new JMSImageBlock();
        $item->setFloating('tut');
    }

    public function testSuccessFloatingModifier()
    {
        $item = new JMSImageBlock();
        $item->setFloating('left');
        $item->setFloating('right');
        $this->assertEquals(2, count($item->getFloatingAllowedValues()));
        $this->assertEquals('{"block":"image","modifiers":{"floating":"right"}}', $item->getJMSText());
    }

    public function testFiledSizeModifier()
    {
        $this->setExpectedException(BadModifierValueException::class);
        $item = new JMSImageBlock();
        $item->setSize('super mega big');
    }

    public function testSuccessSizeModifier()
    {
        $item = new JMSImageBlock();
        $item->setSize('wide');
        $this->assertTrue(true);
        $this->assertEquals(1, count($item->getSizeAllowedValues()));
        $this->assertEquals('{"block":"image","modifiers":{"size":"wide"}}', $item->getJMSText());
    }

    public function testFiledWeightModifier()
    {
        $this->setExpectedException(BadModifierValueException::class);
        $item = new JMSHeadlineBlock('');
        $item->setWeight('uaaaH!!!');
    }

    public function testSuccessWeightModifier()
    {
        $item = new JMSHeadlineBlock('');
        $item->setWeight('xs');
        $item->setWeight('sm');
        $item->setWeight('md');
        $item->setWeight('lg');
        $this->assertEquals(4, count($item->getWeightAllowedValues()));
        $this->assertEquals('{"block":"headline","modifiers":{"weight":"lg"},"content":[]}', $item->getJMSText());
    }
}
