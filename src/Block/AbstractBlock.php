<?php

namespace Mildberry\JMSFormat\Block;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class AbstractBlock
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
        return json_encode($this->asJMSArray());
    }
}
