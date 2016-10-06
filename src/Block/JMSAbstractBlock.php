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
     * @return array
     */
    public function getAttributes()
    {
        $attributesName = JMSAttributeHelper::getAllowedAttributes();
        $attributes = [];

        foreach ($attributesName as $name) {
            $interfaceName = JMSAttributeHelper::getAttributeInterfaceClassName($name);
            $methodName = JMSAttributeHelper::getAttributeGetterName($name);

            if ($this instanceof $interfaceName) {
                if ($attributesValue = $this->$methodName()) {
                    $attributes[$name] = $attributesValue;
                }
            }
        }

        return $attributes;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $interfaceName = JMSAttributeHelper::getAttributeInterfaceClassName($name);
            $attributeName = JMSAttributeHelper::getAttributeSetterName($name);

            if ($this instanceof $interfaceName) {
                $this->$attributeName($value);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getModifiers()
    {
        $modifiersName = JMSModifierHelper::getAllowedModifiers();
        $modifiers = [];

        foreach ($modifiersName as $name) {
            $interfaceName = JMSModifierHelper::getModifierInterfaceClassName($name);
            $methodName = JMSModifierHelper::getModifierGetterName($name);

            if ($this instanceof $interfaceName) {
                if ($modifiersValue = $this->$methodName()) {
                    $modifiers[$name] = $modifiersValue;
                }
            }
        }

       return $modifiers;
    }

    /**
     * @param array $modifiers
     * @return $this
     */
    public function setModifiers(array $modifiers)
    {
        foreach ($modifiers as $name => $value) {
            $interfaceName = JMSModifierHelper::getModifierInterfaceClassName($name);
            $methodName = JMSModifierHelper::getModifierSetterName($name);

            if ($this instanceof $interfaceName) {
                $this->$methodName($value);
            }
        }

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function loadFromJMSArray(array $data)
    {
        if (!empty($data['modifiers'])) {
            $this->setModifiers($data['modifiers']);
        }

        if (!empty($data['attributes'])) {
            $this->setAttributes($data['attributes']);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getJMSArray()
    {
        $return = [
            'block' => $this->getBlockName(),
            'modifiers' => $this->getModifiers(),
        ];

        if ($attributes = $this->getAttributes()) {
            $return['attributes'] = $attributes;
        }

        return $return;
    }

    /**
     * @return string
     */
    public function getJMSText()
    {
        return json_encode($this->getJMSArray(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
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

        $attributesName = JMSModifierHelper::getAllowedModifiers();

        foreach ($attributesName as $name) {
            $interfaceName = JMSAttributeHelper::getAttributeInterfaceClassName($name);
            $methodName = JMSAttributeHelper::getAttributeGetterName($name);
            if ($this instanceof $interfaceName) {
                if ($modifiersValue = $this->$methodName()) {
                    $attributes[] = $name.'="'.$modifiersValue.'"';
                }
            }
        }

        return $attributes;
    }
}
