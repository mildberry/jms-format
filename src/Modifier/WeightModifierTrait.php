<?php

namespace Mildberry\JMSFormat\Modifier;

use Mildberry\JMSFormat\Exception\BadModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait WeightModifierTrait
{
    /**
     * @return string
     */
    public function getWeight()
    {
        return (!empty($this->modifiers['weight'])) ? $this->modifiers['weight'] : null;
    }

    /**
     * @param string $weight
     * @return $this
     * @throws BadModifierValueException
     */
    public function setWeight($weight)
    {
        if (!in_array($weight, $this->getWeightAllowedValues())) {
            throw new BadModifierValueException('Weight value: "'.$weight.'" not valid, must be ['.implode(', ', $this->getWeightAllowedValues()).']');
        }

        $this->tagName = $this->getWeightTags()[$weight];
        $this->modifiers['weight'] = $weight;

        return $this;
    }

    /**
     * @return array
     */
    public function getWeightAllowedValues()
    {
        return array_keys($this->getWeightTags());
    }

    /**
     * @return array
     */
    private function getWeightTags()
    {
        return [
            'xs' => 'h4',
            'sm' => 'h3',
            'md' => 'h2',
            'lg' => 'h1',
        ];
    }
}
