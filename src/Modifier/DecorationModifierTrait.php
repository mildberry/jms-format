<?php

namespace Mildberry\JMSFormat\Modifier;

use Mildberry\JMSFormat\Exception\BadModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait DecorationModifierTrait
{
    /**
     * @return array
     */
    public function getDecoration()
    {
        return (!empty($this->modifiers['$decoration'])) ? $this->modifiers['$decoration'] : null;
    }

    /**
     * @param string|array $decoration
     * @return $this
     * @throws BadModifierValueException
     */
    public function setDecoration($decoration)
    {
        if (is_array($decoration)) {
            $this->modifiers['$decoration'] = $decoration;
        } else {
            if (!in_array($decoration, $this->getDecorationAllowedValues())) {
                throw new BadModifierValueException('Decoration value: "' . $decoration . '" not valid, must be [' . implode(', ', $this->getDecorationAllowedValues()) . ']');
            }
            $this->tagName = $this->getDecorationTags()[$decoration];
            array_push($this->modifiers['$decoration'], $decoration);
        }

        $this->modifiers['$decoration'] = array_unique($this->modifiers['$decoration']);

        return $this;
    }

    /**
     * @return array
     */
    public function getDecorationAllowedValues()
    {
        return array_keys($this->getDecorationTags());
    }

    /**
     * @return array
     */
    private function getDecorationTags()
    {
        return [
            'bold' => 'b',
            'italic' => 'i',
            'del' => 'del',
            'underline' => 'u',
        ];
    }
}
