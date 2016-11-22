<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\Tests\TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatCollectionTest extends TestCase
{
    public function testCollection()
    {
        $collection = new JMSCollectionBlock();
        $this->assertTrue($collection instanceof \ArrayAccess);

        $collection->insertFirstBlock(new JMSTextBlock('content'));
        $this->assertTrue($collection->offsetExists(0));
        $this->assertEquals(1, $collection->count());
        $block = $collection->offsetGet(0);
        $collection->offsetSet(0, $block);
        $this->assertEquals('{"version":"v1","content":[{"block":"body","modifiers":[],"content":[{"block":"text","modifiers":[],"content":"content"}]}]}', $this->asJmsText($collection));
        $collection->offsetUnset(0);
        $this->assertEquals(0, $collection->getIterator()->count());
    }
}
