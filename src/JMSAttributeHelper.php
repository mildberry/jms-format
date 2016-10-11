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
        return ['src', 'data-paragraph-id'];
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getAttributeInterfaceClassName($name)
    {
        return __NAMESPACE__.'\Interfaces\\'.str_replace('-','', ucwords(strtolower($name), '-')).'AttributeInterface';
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getAttributeGetterName($name)
    {
        return 'get'.str_replace('-','', ucwords(strtolower($name), '-'));
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getAttributeSetterName($name)
    {
        return 'set'.str_replace('-','', ucwords(strtolower($name), '-'));
    }
}
