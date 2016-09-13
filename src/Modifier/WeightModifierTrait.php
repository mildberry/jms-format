<?php

namespace Mildberry\JMSFormat\Modifier;

use Mildberry\JMSFormat\Exception\WrongModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait WeightModifierTrait
{
    /**
     * @var string
     */
    protected $weight;

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     * @return $this
     * @throws WrongModifierValueException
     */
    public function setWeight($weight)
    {
        if (!in_array($weight, $this->getWeightAllowedValues())) {
            throw new WrongModifierValueException('Weight value: "'.$weight.'" not valid, must be ['.implode(',', $this->getWeightAllowedValues()).']');
        }

        $this->weight = $weight;

        return $this;
    }

    /**
     * @return array
     */
    public function getWeightAllowedValues()
    {
        return ['h1', 'h2', 'h3', 'h4', 'h5'];
    }
}
