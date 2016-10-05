<?php

namespace Mildberry\JMSFormat\Modifier;

use Mildberry\JMSFormat\Exception\BadModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait FloatingModifierTrait
{
    /**
     * @return string
     */
    public function getFloating()
    {
        return (!empty($this->modifiers['floating'])) ? $this->modifiers['floating'] : null;
    }

    /**
     * @param string $floating
     * @return $this
     * @throws BadModifierValueException
     */
    public function setFloating($floating)
    {
        if (!in_array($floating, $this->getFloatingAllowedValues())) {
            throw new BadModifierValueException('Floating value: "'.$floating.'" not valid, must be ['.implode(', ', $this->getFloatingAllowedValues()).']');
        }

        $this->modifiers['floating'] = $floating;

        return $this;
    }

    /**
     * @return array
     */
    public function getFloatingAllowedValues()
    {
        return ['left', 'right'];
    }
}
