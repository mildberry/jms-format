<?php

namespace Mildberry\JMSFormat\Modifier;

use Mildberry\JMSFormat\Exception\BadModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait AlignmentModifierTrait
{
    /**
     * @return string
     */
    public function getAlignment()
    {
        return (!empty($this->modifiers['alignment'])) ? $this->modifiers['alignment'] : null;
    }

    /**
     * @param string $alignment
     * @return $this
     * @throws BadModifierValueException
     */
    public function setAlignment($alignment)
    {
        if (!in_array($alignment, $this->getAlignmentAllowedValues())) {
            throw new BadModifierValueException('Alignment value: "'.$alignment.'" not valid, must be ['.implode(', ', $this->getAlignmentAllowedValues()).']');
        }

        $this->modifiers['alignment'] = $alignment;

        return $this;
    }

    /**
     * @return array
     */
    public function getAlignmentAllowedValues()
    {
        return ['left', 'center', 'right'];
    }
}
