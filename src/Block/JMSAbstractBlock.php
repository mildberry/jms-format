<?php

namespace Mildberry\JMSFormat\Block;

use Mildberry\JMSFormat\JMSAttributeHelper;
use Mildberry\JMSFormat\JMSModifierHelper;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
abstract class JMSAbstractBlock
{
    /**
     * @var string
     */
    protected $blockName;

    /**
     * @var string
     */
    protected $tagName;

    /**
     * @return string
     */
    public function getBlockName()
    {
        return $this->blockName;
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * @return string
     */
    public function getHTMLText()
    {
        return '<'.$this->getTagName().$this->getModifiersClassesString().$this->getAttributesHtmlString().'>';
    }

    /**
     * @return string
     */
    protected function getModifiersClassesString()
    {
        $classes = $this->getModifiersClasses();

        return (!empty($classes)) ? ' class="'.implode(' ', $classes).'"' : '';
    }

    /**
     * @return array
     */
    protected function getModifiersClasses()
    {
        $classes = [];

        $modifiersName = JMSModifierHelper::getAllowedModifiers();

        foreach ($modifiersName as $name) {
            $interfaceName = JMSModifierHelper::getModifierInterfaceClassName($name);
            $methodName = JMSModifierHelper::getModifierGetterHtmlClass($name);

            if ($this instanceof $interfaceName) {
                if ($modifiersValue = $this->$methodName()) {
                    $classes[] = $modifiersValue;
                }
            }
        }

        return $classes;
    }

    /**
     * @return string
     */
    protected function getAttributesHtmlString()
    {
        $attributes = $this->getAttributeHtml();

        return (!empty($attributes)) ? ' '.implode(' ', $attributes) : '';
    }

    /**
     * @return array
     */
    protected function getAttributeHtml()
    {
        $attributes = [];

        $attributesName = JMSAttributeHelper::getAllowedAttributes();

        foreach ($attributesName as $name) {
            $interfaceName = JMSAttributeHelper::getAttributeInterfaceClassName($name);
            $methodName = JMSAttributeHelper::getAttributeGetterName($name);
            if ($this instanceof $interfaceName) {
                if ($attributeValue = $this->$methodName()) {
                    $attributes[] = $name.'="'.$attributeValue.'"';
                }
            }
        }

        return $attributes;
    }
}
