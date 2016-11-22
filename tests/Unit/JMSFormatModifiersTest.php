<?php

namespace Mildberry\JMSFormat\Tests\Unit;

use Mildberry\JMSFormat\Exception\BadModifierValueException;
use Mildberry\JMSFormat\Block\JMSParagraphBlock;
use Mildberry\JMSFormat\Block\JMSHeadlineBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\JMSModifierHelper;
use Mildberry\JMSFormat\Tests\TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatModifiersTest extends TestCase
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
        $this->assertEquals('{"version":"v1","content":[{"block":"paragraph","modifiers":{"alignment":"right"}}]}', $this->asJmsText($item));
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
        $this->assertEquals('{"version":"v1","content":[{"block":"text","modifiers":{"color":"danger"},"content":"content"}]}', $this->asJmsText($item));
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
        $this->assertEquals('{"version":"v1","content":[{"block":"text","modifiers":{"decoration":["bold","italic","del","underline"]},"content":"content"}]}', $this->asJmsText($item));
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
        $this->assertEquals('{"version":"v1","content":[{"block":"image","modifiers":{"floating":"right"}}]}', $this->asJmsText($item));
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
        $item->setSize('xs');
        $item->setSize('lg');
        $item->setSize('md');
        $item->setSize('wide');
        $this->assertTrue(true);
        $this->assertEquals(4, count($item->getSizeAllowedValues()));
        $this->assertEquals('{"version":"v1","content":[{"block":"image","modifiers":{"size":"wide"}}]}', $this->asJmsText($item));
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
        $this->assertEquals('{"version":"v1","content":[{"block":"headline","modifiers":{"weight":"lg"}}]}', $this->asJmsText($item));
    }
}
