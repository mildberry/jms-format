<?php

namespace Mildberry\JMSFormat\Block;

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
     * @var array
     */
    protected $modifiers;

    /**
     * @var array
     */
    protected $attributes;

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

        return $this;
    }

    /**
     * @return array
     */
    public function getJMSArray()
    {
        return [
            'block' => $this->getBlockName(),
            'modifiers' => $this->getModifiers(),
        ];
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
        return '<'.$this->getTagName().$this->getModifiersClassesString().'>';
    }

    /**
     * @return string
     */
    protected function getModifiersClassesString()
    {
        $classes = $this->getModifiersClasses();

        return (!empty($classes)) ? ' classes="'.implode(' ', $classes).'"' : '';
    }

    /**
     * @return array
     */
    protected function getModifiersClasses()
    {
        $classes = [];

        foreach ($this->getModifiers() as $name => $modifiers) {
            if (is_string($modifiers)) {
                $modifiers = [$modifiers];
            }
            foreach ($modifiers as $modifier) {
                $classes[] = $name.'-'.$modifier;
            }
        }

        return $classes;
    }
}
