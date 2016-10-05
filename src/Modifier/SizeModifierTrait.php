<?php

namespace Mildberry\JMSFormat\Modifier;

use Mildberry\JMSFormat\Exception\BadModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait SizeModifierTrait
{
    /**
     * @return string
     */
    public function getSize()
    {
        return (!empty($this->modifiers['size'])) ? $this->modifiers['size'] : null;
    }

    /**
     * @param string $size
     * @return $this
     * @throws BadModifierValueException
     */
    public function setSize($size)
    {
        if (!in_array($size, $this->getSizeAllowedValues())) {
            throw new BadModifierValueException('Size value: "'.$size.'" not valid, must be ['.implode(', ', $this->getSizeAllowedValues()).']');
        }

        $this->modifiers['size'] = $size;

        return $this;
    }

    /**
     * @return array
     */
    public function getSizeAllowedValues()
    {
        return ['wide'];
    }
}
