<?php

namespace Mildberry\JMSFormat\Modifier;

use Mildberry\JMSFormat\Exception\BadModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait DecorationModifierTrait
{
    /**
     * @var array
     */
    protected $decoration = [];

    /**
     * @return array
     */
    public function getDecoration()
    {
        return $this->decoration;
    }

    /**
     * @param string|array $decoration
     * @return $this
     * @throws BadModifierValueException
     */
    public function setDecoration($decoration)
    {
        if (is_array($decoration)) {
            $this->decoration = $decoration;
        } else {
            if (!in_array($decoration, $this->getDecorationAllowedValues())) {
                throw new BadModifierValueException('Decoration value: "' . $decoration . '" not valid, must be [' . implode(',', $this->getDecorationAllowedValues()) . ']');
            }

            array_push($this->decoration, $decoration);
        }
        $this->decoration = array_unique($this->decoration);

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
