<?php

namespace Mildberry\JMSFormat\Modifier;

use Mildberry\JMSFormat\Exception\BadModifierValueException;

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
     * @throws BadModifierValueException
     */
    public function setWeight($weight)
    {
        if (!in_array($weight, $this->getWeightAllowedValues())) {
            throw new BadModifierValueException('Weight value: "'.$weight.'" not valid, must be ['.implode(', ', $this->getWeightAllowedValues()).']');
        }

        $this->tagName = $this->getWeightTags()[$weight];
        $this->weight = $weight;

        return $this;
    }

    /**
     * @param string $tagName
     * @return string
     */
    public function getWeightByTag($tagName)
    {
        return array_search($tagName, $this->getWeightTags());
    }

    /**
     * @return string
     */
    public function getWeightHtmlClass()
    {
        return ($this->weight && $this->getWeightTags()[$this->weight] != $this->tagName) ? 'weight-'.$this->getWeight() : null;
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
