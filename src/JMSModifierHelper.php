<?php

namespace Mildberry\JMSFormat;

use Mildberry\JMSFormat\Block\JMSAbstractBlock;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSModifierHelper
{
    /**
     * @return array
     */
    public static function getAllowedModifiers()
    {
        return ['alignment', 'color', 'floating', 'size', 'weight', 'decoration'];
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getModifierInterfaceClassName($name)
    {
        return __NAMESPACE__.'\Interfaces\\'.ucfirst(strtolower($name)).'ModifierInterface';
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getModifierGetterName($name)
    {
        return 'get'.ucfirst(strtolower($name));
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getModifierGetterHtmlClass($name)
    {
        return 'get'.ucfirst(strtolower($name)).'HtmlClass';
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getModifierSetterName($name)
    {
        return 'set'.ucfirst(strtolower($name));
    }

    /**
     * @param JMSAbstractBlock $block
     * @return array
     */
    public static function getBlockModifiers(JMSAbstractBlock $block)
    {
        $modifiersName = static::getAllowedModifiers();
        $modifiers = [];

        foreach ($modifiersName as $name) {
            $interfaceName = static::getModifierInterfaceClassName($name);
            $methodName = static::getModifierGetterName($name);

            if ($block instanceof $interfaceName) {
                if ($modifiersValue = $block->$methodName()) {
                    $modifiers[$name] = $modifiersValue;
                }
            }
        }

        return $modifiers;
    }

    /**
     * @param JMSAbstractBlock $block
     * @param array $modifiers
     */
    public static function setBlockModifiers(JMSAbstractBlock &$block, array $modifiers)
    {
        foreach ($modifiers as $name => $value) {
            $interfaceName = static::getModifierInterfaceClassName($name);
            $methodName = static::getModifierSetterName($name);

            if ($block instanceof $interfaceName) {
                $block->$methodName($value);
            }
        }
    }
}
