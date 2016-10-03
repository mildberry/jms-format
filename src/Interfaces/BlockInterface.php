<?php

namespace Mildberry\JMSFormat\Interfaces;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
interface BlockInterface
{
    public function getBlockName();

    /**
     * @return array
     */
    public function getModifiers();

    /**
     * @param array $modifiers
     * @return $this
     */
    public function setModifiers(array $modifiers);

    /**
     * @param array $data
     * @return $this
     */
    public function loadFromJMSArray(array $data);

    /**
     * @return array
     */
    public function asJMSArray();

    /**
     * @return string
     */
    public function asJMSText();
}
