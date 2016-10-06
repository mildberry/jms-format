<?php

namespace Mildberry\JMSFormat\Interfaces;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
interface DecorationModifierInterface
{
    /**
     * @return array
     */
    public function getDecoration();

    /**
     * @return array
     */
    public function getDecorationHtmlClass();
}
