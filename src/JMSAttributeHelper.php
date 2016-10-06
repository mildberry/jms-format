<?php

namespace Mildberry\JMSFormat;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSAttributeHelper
{
    /**
     * @return array
     */
    public static function getAllowedAttributes()
    {
        return ['src', 'dataParagraphId'];
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getAttributeInterfaceClassName($name)
    {
        return __NAMESPACE__.'\Interfaces\\'.ucfirst(strtolower($name)).'AttributeInterface';
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getAttributeGetterName($name)
    {
        return 'get'.ucfirst(strtolower($name));
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getAttributeSetterName($name)
    {
        return 'set'.ucfirst(strtolower($name));
    }
}
