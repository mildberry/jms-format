<?php

namespace Mildberry\Library\ContentFormatter\Modifier;

use Mildberry\Library\ContentFormatter\Exception\WrongModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait FloatingModifierTrait
{
    /**
     * @var string
     */
    protected $floating;

    /**
     * @return string
     */
    public function getFloating()
    {
        return $this->floating;
    }

    /**
     * @param string $floating
     * @return $this
     * @throws WrongModifierValueException
     */
    public function setFloating($floating)
    {
        if (!in_array($floating, $this->getFloatingAllowedValues())) {
            throw new WrongModifierValueException('Floating value: "'.$floating.'" not valid, must be ['.implode(',', $this->getFloatingAllowedValues()).']');
        }

        $this->floating = $floating;

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
