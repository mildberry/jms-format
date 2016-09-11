<?php

namespace Mildberry\Library\ContentFormatter\Test\Unit;

use Mildberry\Library\ContentFormatter\ContentFormatter;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class ContentFormatterTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $contentFormatter = new ContentFormatter();
        $this->assertTrue(($contentFormatter instanceof ContentFormatter));
    }
}
