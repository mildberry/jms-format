<?php

namespace Mildberry\JMSFormat\Block;

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
        $modifiersName = ['alignment', 'color', 'floating', 'size', 'src', 'weight', 'decoration'];
        $modifiers = [];

        foreach ($modifiersName as $name) {
            $interfaceName = 'Mildberry\JMSFormat\Modifier\\'.ucfirst($name).'ModifierInterface';
            $methodName = 'get'.ucfirst($name);

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
            $interfaceName = 'Mildberry\JMSFormat\Modifier\\'.ucfirst($name).'ModifierInterface';
            $methodName = 'set'.ucfirst($name);

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
