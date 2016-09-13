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
            $interfaceName = 'Mildberry\Library\ContentFormatter\Modifier\Interface'.ucfirst($name).'Modifier';
            $methodName = 'get'.ucfirst($name);

            if ($this instanceof $interfaceName) {
                $modifiersValues = $this->$methodName();
                if ($modifiersValues) {
                    $modifiers[$name] = $modifiersValues;
                }
            }
        }

       return $modifiers;
    }
}
