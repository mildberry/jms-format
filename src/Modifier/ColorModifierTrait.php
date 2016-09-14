<?php

namespace Mildberry\JMSFormat\Modifier;

use Mildberry\JMSFormat\Exception\BadModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait ColorModifierTrait
{
    /**
     * @var string
     */
    protected $color;

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return $this
     * @throws BadModifierValueException
     */
    public function setColor($color)
    {
        if (!in_array($color, $this->getColorAllowedValues())) {
            throw new BadModifierValueException('Color value: "'.$color.'" not valid, must be ['.implode(',', $this->getColorAllowedValues()).']');
        }

        $this->color = $color;

        return $this;
    }

    /**
     * @return array
     */
    public function getColorAllowedValues()
    {
        return ['muted', 'success', 'info', 'warning', 'danger'];
    }
}
