<?php

namespace Mildberry\JMSFormat\Tests;

use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Parser\HtmlParser;
use Mildberry\JMSFormat\Parser\JmsParser;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JmsParser
     */
    protected $jmsParser;

    /**
     * @var HtmlParser
     */
    protected $htmlParser;

    /**
     * TestCase constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->jmsParser = new JmsParser();
        $this->htmlParser = new HtmlParser();
    }

    /**
     * @param JMSAbstractBlock $item
     * @return string
     */
    protected function asJmsText($item)
    {
        return $this->jmsParser->toContent((new JMSCollectionBlock())->addBlock($item));
    }

    protected function asHtmlText($item)
    {
        return $this->htmlParser->toContent((new JMSCollectionBlock())->addBlock($item));
    }
}