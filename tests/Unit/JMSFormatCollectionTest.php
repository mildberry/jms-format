<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\Parser\JmsParser;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JmsParser
     */
    protected $jms;

    public function __construct()
    {
        parent::__construct();

        $this->jms = new JmsParser();
    }

    public function testCollection()
    {
        $collection = new JMSCollectionBlock();
        $this->assertTrue($collection instanceof \ArrayAccess);

        $collection->insertFirstBlock(new JMSTextBlock('content'));
        $this->assertTrue($collection->offsetExists(0));
        $this->assertEquals(1, $collection->count());
        $block = $collection->offsetGet(0);
        $collection->offsetSet(0, $block);
        $this->assertEquals('{"version":"v1","content":[{"block":"text","modifiers":[],"content":"content"}]}', $this->asText($collection));
        $collection->offsetUnset(0);
        $this->assertEquals(0, $collection->getIterator()->count());
    }

    /**
     * @param JMSCollectionBlock $item
     * @return string
     */
    private function asText($item)
    {
        return $this->jms->toContent($item);
    }
}
