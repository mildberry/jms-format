<?php

namespace Mildberry\JMSFormat;

use DOMNamedNodeMap;
use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSBlockquoteBlock;
use Mildberry\JMSFormat\Block\JMSHeadlineBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSParagraphBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\Exception\BadBlockNameException;

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
        $className = __NAMESPACE__ . '\\Block\\JMS' . ucfirst(strtolower($name)) . 'Block';

        if (!class_exists($className)) {
            throw new BadBlockNameException('Class from block "' . $name . '" not exists');
        }

        $block = new $className;

        if (!$block instanceof JMSAbstractBlock) {
            throw new BadBlockNameException('Class "' . $className . '" not block');
        }

        return $block;
    }

    /**
     * @param string $name
     * @param $value
     * @return JMSAbstractBlock
     * @throws BadBlockNameException
     */
    public static function createBlockClass($name, $value)
    {
        switch ($name) {
            case 'span':
            case 'u':
            case 'b':
            case 'i':
            case 'del':
                $block = (new JMSTextBlock($value));
                $block->setDecoration($block->getDecorationByTag($name));
                break;
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
                $block = (new JMSHeadlineBlock($value));
                $block->setWeight($block->getWeightByTag($name));
                break;
            case 'img':
                $block = new JMSImageBlock($value);
                break;
            case 'p':
                $block = new JMSParagraphBlock($value);
                break;
            case 'blockquote':
                $block = new JMSBlockquoteBlock($value);
                break;
            default:
                throw new BadBlockNameException('Class for tag "' . $name . '" not found');
                break;
        }

        return $block;
    }

    /**
     * @param string $name
     * @param string $value
     * @param DOMNamedNodeMap $nodeAttributes
     * @param array $parentModifiers
     * @return JMSAbstractBlock
     * @throws BadBlockNameException
     */
    public static function createBlockByTagName($name, $value, DOMNamedNodeMap $nodeAttributes, array $parentModifiers)
    {
        $block = static::createBlockClass($name, $value);

        $allowedModifiers = JMSModifierHelper::getAllowedModifiers();
        $allowedAttributes = JMSAttributeHelper::getAllowedAttributes();

        foreach ($nodeAttributes as $nodeAttribute) {
            if ($nodeAttribute->nodeName == 'class') {

                foreach (explode(' ', $nodeAttribute->nodeValue) as $class) {
                    list($modifier, $value) = array_pad(explode('-', $class), 2, '');

                    if (in_array($modifier, $allowedModifiers) && $modifier && $value) {
                        $modifierClassName = JMSModifierHelper::getModifierInterfaceClassName($modifier);
                        if ($block instanceof $modifierClassName) {
                            $methodName = JMSModifierHelper::getModifierSetterName($modifier);
                            $block->$methodName($value);
                        }
                    }
                }
            } elseif (in_array($nodeAttribute->name, $allowedAttributes)) {
                $attributeClassName = JMSAttributeHelper::getAttributeInterfaceClassName($nodeAttribute->name);
                if ($block instanceof $attributeClassName) {
                    $methodName = JMSAttributeHelper::getAttributeSetterName($nodeAttribute->name);
                    $block->$methodName($nodeAttribute->value);
                }
            }
        }

        return $block->setModifiers($parentModifiers);
    }
}
