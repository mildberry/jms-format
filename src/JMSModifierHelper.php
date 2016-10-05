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
        return ['alignment', 'color', 'floating', 'size', 'src', 'weight', 'decoration'];
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
    public static function getModifierSetterName($name)
    {
        return 'set'.ucfirst(strtolower($name));
    }

    /**
     * @param string|array $values
     * @return string
     */
    public static function getTagNameByModifierValue($values)
    {
        if (!is_array($values)) {
            $values = [$values];
        }

        foreach ($values as $value) {
            switch ($value) {
                case 'bold':
                    return 'b';
                    break;
                case 'italic':
                    return 'i';
                    break;
                case 'del':
                    return 'del';
                    break;
                case 'underline':
                    return 'u';
                    break;
                case 'xs':
                    return 'h4';
                    break;
                case 'sm':
                    return 'h3';
                    break;
                case 'md':
                    return 'h2';
                    break;
                case 'lg':
                    return 'h1';
                    break;
            }
        }
    }
}
