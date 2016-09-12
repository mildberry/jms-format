<?php

namespace Mildberry\Library\ContentFormatter\Modifier;

use Mildberry\Library\ContentFormatter\Exception\WrongModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait AlignmentModifierTrait
{
    /**
     * @var string
     */
    protected $alignment;

    /**
     * @return string
     */
    public function getAlignment()
    {
        return $this->alignment;
    }

    /**
     * @param string $alignment
     * @return $this
     * @throws WrongModifierValueException
     */
    public function setAlignment($alignment)
    {
        if (!in_array($alignment, $this->getAlignmentAllowedValues())) {
            throw new WrongModifierValueException('Alignment value: "'.$alignment.'" not valid, must be ['.implode(',', $this->getAlignmentAllowedValues()).']');
        }

        $this->alignment = $alignment;

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
