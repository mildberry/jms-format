<?php

namespace Mildberry\JMSFormat\Interfaces;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
interface FloatingModifierInterface
{
    /**
     * @return string
     */
    public function getFloating();

    /**
     * @return string
     */
    public function getFloatingHtmlClass();
}
