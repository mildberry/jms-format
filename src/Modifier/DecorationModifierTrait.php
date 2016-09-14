<?php

namespace Mildberry\JMSFormat\Modifier;

use Mildberry\JMSFormat\Exception\WrongModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait DecorationModifierTrait
{
    /**
     * @var string
     */
    protected $decoration;

    /**
     * @return string
     */
    public function getDecoration()
    {
        return $this->decoration;
    }

    /**
     * @param string $decoration
     * @return $this
     * @throws WrongModifierValueException
     */
    public function setDecoration($decoration)
    {
        if (!in_array($decoration, $this->getDecorationAllowedValues())) {
            throw new WrongModifierValueException('Decoration value: "'.$decoration.'" not valid, must be ['.implode(',', $this->getDecorationAllowedValues()).']');
        }

        $this->decoration = $decoration;

        return $this;
    }

    /**
     * @return array
     */
    public function getDecorationAllowedValues()
    {
        return ['bold', 'italic', 'del'];
    }
}
