<?php

namespace Mildberry\JMSFormat\Interfaces;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
interface SizeModifierInterface
{
    /**
     * @return string
     */
    public function getSize();

    /**
     * @return string
     */
    public function getSizeHtmlClass();
}
