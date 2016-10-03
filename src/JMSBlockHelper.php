<?php

namespace Mildberry\JMSFormat;

use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSBlockquoteBlock;
use Mildberry\JMSFormat\Block\JMSHeadlineBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSParagraphBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\Exception\BadBlockNameException;
use Mildberry\JMSFormat\Interfaces\AlignmentModifierInterface;
use Mildberry\JMSFormat\Interfaces\ColorModifierInterface;
use Mildberry\JMSFormat\Interfaces\DecorationModifierInterface;
use Mildberry\JMSFormat\Interfaces\FloatingModifierInterface;
use Mildberry\JMSFormat\Interfaces\SizeModifierInterface;
use Mildberry\JMSFormat\Interfaces\SrcModifierInterface;
use Mildberry\JMSFormat\Interfaces\WeightModifierInterface;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSBlockHelper
{
    /**
     * @param string $name
     * @return JMSAbstractBlock
     * @throws BadBlockNameException
     */
    public static function createBlockByName($name)
    {
        $className = __NAMESPACE__.'\\Block\\JMS'.ucfirst(strtolower($name)).'Block';

        if (!class_exists($className)) {
            throw new BadBlockNameException('Class from block "'.$name.'" not exists');
        }

        $block = new $className;

        if (!$block instanceof JMSAbstractBlock) {
            throw new BadBlockNameException('Class "'.$className.'" not block');
        }

        return $block;
    }

    /**
     * @param string $name
     * @param string $value
     * @return JMSAbstractBlock
     * @throws BadBlockNameException
     */
    public static function createBlockByTagName($name, $value)
    {
        switch ($name) {
            case 'span': case 'u': case 'b': case 'i': case 'del':
                $className = JMSTextBlock::class;
                break;
            case 'h1': case 'h2': case 'h3': case 'h4':
                $className = JMSHeadlineBlock::class;
                break;
            case 'img':
                $className = JMSImageBlock::class;
                break;
            case 'p':
                $className = JMSParagraphBlock::class;
                break;
            case 'blockquote':
                $className = JMSBlockquoteBlock::class;
                break;
            default:
                $className = '';
                break;
        }

        $block = new $className($value);

        if (!$block instanceof JMSAbstractBlock) {
            throw new BadBlockNameException('Class "'.$className.'" not block');
        }

        return $block;
    }

    /**
     * @param JMSAbstractBlock $block
     * @return string
     */
    public static function getTagSourceByBlock(JMSAbstractBlock $block)
    {
        $tagName = '';
        $classes = [];

        if ($block instanceof DecorationModifierInterface) {
            $tagName = 'span';
            if (count($block->getDecoration()) == 1) {
                switch($block->getDecoration()[0]) {
                    case 'bold':
                        $tagName = 'b';
                        break;
                    case 'italic':
                        $tagName = 'i';
                        break;
                    case 'del':
                        $tagName = 'del';
                        break;
                    case 'underline':
                        $tagName = 'u';
                        break;
                }
            }
            if (count($block->getDecoration()) > 1) {
                foreach ($block->getDecoration() as $decoration) {
                    $classes[] = 'decoration-'.$decoration;
                }
            }
        }

        if ($block instanceof ColorModifierInterface && $block->getColor()) {
            $classes[] = 'color-'.$block->getColor();
        }

        if ($block instanceof AlignmentModifierInterface) {
            $tagName = 'p';
            $classes[] = 'alignment-'.$block->getAlignment();
        }

        if ($block instanceof FloatingModifierInterface) {
            $tagName = 'img';
            $classes[] = 'floating-'.$block->getFloating();
        }

        if ($block instanceof SizeModifierInterface) {
            $tagName = 'img';
            $classes[] = 'size-'.$block->getSize();
        }

        if ($block instanceof SrcModifierInterface) {
            $tagName = 'img src="'.$block->getSrc().'"';
        }

        if ($block->getBlockName() == 'headline') {
            $tagName = 'h1';
        }

        if ($block instanceof WeightModifierInterface) {
            switch ($block->getWeight()) {
                case 'xs':
                    $tagName = 'h4';
                    break;
                case 'sm':
                    $tagName = 'h3';
                    break;
                case 'md':
                    $tagName = 'h2';
                    break;
                case 'lg';
                    $tagName = 'h1';
                    break;
            }
        }

        return $tagName.((count($classes) > 0) ? ' class="'.implode(' ', $classes).'"' : '');
    }
}
