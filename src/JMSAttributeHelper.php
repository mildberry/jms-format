<?php

namespace Mildberry\JMSFormat;

use Mildberry\JMSFormat\Block\JMSAbstractBlock;

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
        return ['src', 'paragraphId'];
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

    /**
     * @param JMSAbstractBlock $block
     * @return array
     */
    public static function getBlockAttributes(JMSAbstractBlock $block)
    {
        $attributesName = static::getAllowedAttributes();
        $attributes = [];

        foreach ($attributesName as $name) {
            $interfaceName = static::getAttributeInterfaceClassName($name);
            $methodName = static::getAttributeGetterName($name);

            if ($block instanceof $interfaceName) {
                if ($attributesValue = $block->$methodName()) {
                    $attributes[$name] = $attributesValue;
                }
            }
        }

        return $attributes;
    }

    /**
     * @param JMSAbstractBlock $block
     * @param array $attributes
     */
    public static function setBlockAttributes(JMSAbstractBlock &$block, array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $interfaceName = JMSAttributeHelper::getAttributeInterfaceClassName($name);
            $attributeName = JMSAttributeHelper::getAttributeSetterName($name);

            if ($block instanceof $interfaceName) {
                $block->$attributeName($value);
            }
        }
    }
}
