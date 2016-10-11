<?php

namespace Mildberry\JMSFormat;

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
}
