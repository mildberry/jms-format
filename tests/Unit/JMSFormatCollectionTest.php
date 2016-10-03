<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testCollection()
    {
        $this->expectOutputString('{"block":"body","modifiers":[],"content":[]}');

        $collection = new JMSCollectionBlock();
        $this->assertTrue($collection instanceof \ArrayAccess);

        $collection->insertFirstBlock(new JMSTextBlock('content'));
        $this->assertTrue($collection->offsetExists(0));
        $this->assertEquals(1, $collection->count());
        $block = $collection->offsetGet(0);
        $collection->offsetSet(0, $block);
        $this->assertEquals('{"block":"body","modifiers":[],"content":[{"block":"text","modifiers":[],"content":"content"}]}', $collection->toJson());
        $collection->offsetUnset(0);
        $this->assertEquals(0, $collection->getIterator()->count());

        print $collection;
    }
}
