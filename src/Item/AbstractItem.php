<?php

namespace Mildberry\Library\ContentFormatter\Item;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class AbstractItem
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
        $modifiersName = ['alignment', 'color', 'floating', 'size', 'src', 'weight'];
        $modifiers = [];

        foreach ($modifiersName as $name) {
            $interfaceName = 'Mildberry\Library\ContentFormatter\Modifier\\'.ucfirst($name).'ModifierInterface';
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
        $data = [
            'block' => $this->getBlockName(),
        ];

        if ($modifiers = $this->getModifiers()) {
            $data['modifiers'] = $modifiers;
        }

        return $data;
    }

    /**
     * @return string
     */
    public function asJMSText()
    {
        return json_encode($this->asJMSArray());
    }
}
