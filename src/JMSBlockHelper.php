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
use Mildberry\JMSFormat\Interfaces\SourceAttributeInterface;
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
     * @return string
     */
    public static function getClassByTagName($name)
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

        return $className;
    }

    /**
     * @param string $name
     * @param string $value
     * @return JMSAbstractBlock
     * @throws BadBlockNameException
     */
    public static function createBlockByTagName($name, $value)
    {
        $className = static::getClassByTagName($name);
        $block = new $className($value);

        if (!$block instanceof JMSAbstractBlock) {
            throw new BadBlockNameException('Class "'.$className.'" not block');
        }

        return $block;
    }

    /**
     * @param JMSAbstractBlock $block
     * @param string $content
     * @return string
     */
    public static function getTagSourceByBlock(JMSAbstractBlock $block, $content = '')
    {
        $tagName = '';
        $classes = [];
        $modifiers = JMSModifierHelper::getAllowedModifiers();

        foreach ($modifiers as $modifier) {
            $method = JMSModifierHelper::getModifierGetterName($modifier);
            $instance = JMSModifierHelper::getModifierInterfaceClassName($modifier);
            if ($block instanceof $instance && $value = $block->$method()) {
                if (!$tagName && $name = JMSModifierHelper::getTagNameByModifierValue($value)) {
                    $tagName = $name;
                }

                if (is_array($value)) {
                    foreach ($value as $item) {
                        if (get_class($block) <> static::getClassByTagName($tagName)) {
                            $classes[] = $modifier . '-' . $item;
                        }
                    }
                } else {
                    if (get_class($block) <> static::getClassByTagName($tagName)) {
                        $classes[] = $modifier . '-' . $value;
                    }
                }
            }
        }
//        die($block->getBlockName());
//        if (!$tagName && $block->getBlockName() == 'headline') {
//            $tagName = 'h1';
//        }

        if (!$tagName && !empty($classes)) {
            $tagName = 'span';
        }

        return (($tagName) ? '<'.$tagName.((count($classes) > 0) ? ' class="'.implode(' ', $classes).'"' : '').'>' : '').(($content) ? $content.(($tagName) ? '</'.$tagName.'>' : '') : '');
    }
}
