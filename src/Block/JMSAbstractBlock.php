<?php

namespace Mildberry\JMSFormat\Block;
use Mildberry\JMSFormat\JMSModifierHelper;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSAbstractBlock
{
    /**
     * @var string
     */
    protected $blockName;

    /**
     * @return string
     */
    public function getBlockName()
    {
        return $this->blockName;
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
     * @return array
     */
    public function asJMSArray()
    {
        return [
            'block' => $this->getBlockName(),
            'modifiers' => $this->getModifiers(),
        ];
    }

    /**
     * @return string
     */
    public function asJMSText()
    {
        return json_encode($this->asJMSArray(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
