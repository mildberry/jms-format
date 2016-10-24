<?php

namespace Mildberry\JMSFormat\Test\Unit;

use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSParagraphBlock;
use Mildberry\JMSFormat\Block\JMSImageBlock;
use Mildberry\JMSFormat\Block\JMSVideoBlock;
use Mildberry\JMSFormat\JMSAttributeHelper;
use Mildberry\JMSFormat\Parser\HtmlParser;
use Mildberry\JMSFormat\Parser\JmsParser;
use PHPUnit_Framework_TestCase;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSFormatAttributesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var JmsParser
     */
    protected $jmsParser;

    /**
     * @var HtmlParser
     */
    protected $htmlParser;

    public function __construct()
    {
        parent::__construct();

        $this->jmsParser = new JmsParser();
        $this->htmlParser = new HtmlParser();
    }

    public function testSuccessAttributeHelper()
    {
        $this->assertEquals(['src', 'paragraphId', 'videoSrc', 'videoId', 'videoProvider'], JMSAttributeHelper::getAllowedAttributes());
        $this->assertEquals('Mildberry\JMSFormat\Interfaces\ParagraphidAttributeInterface', JMSAttributeHelper::getAttributeInterfaceClassName('paragraphId'));
    }

    public function testSuccessSrcAttribute()
    {
        $item = new JMSImageBlock();
        $item->setSrc('http://www.ya.ru');
        $this->assertEquals('{"version":"v1","content":[{"block":"image","modifiers":[],"attributes":{"src":"http://www.ya.ru"}}]}', $this->asJmsText($item));
        $this->assertEquals('<img src="http://www.ya.ru">', $this->asHtmlText($item));
    }

    public function testSuccessDataParagraphIdAttribute()
    {
        $item = new JMSParagraphBlock();
        $item->setParagraphId("1");
        $this->assertEquals('{"version":"v1","content":[{"block":"paragraph","modifiers":[],"attributes":{"paragraphId":"1"}}]}', $this->asJmsText($item));
        $this->assertEquals('<p data-paragraph-id="1"></p>', $this->asHtmlText($item));
    }

    public function testSuccessVideoIdAttribute()
    {
        $item = new JMSVideoBlock();
        $item->setVideoId('123123');
        $this->assertEquals('{"version":"v1","content":[{"block":"video","modifiers":[],"attributes":{"videoId":"123123"}}]}', $this->asJmsText($item));
        $this->assertEquals('<object data-video-id="123123"><embed /></object>', $this->asHtmlText($item));
    }

    public function testSuccessVideoProviderAttribute()
    {
        $item = new JMSVideoBlock();
        $item->setVideoProvider('youtube');
        $this->assertEquals('{"version":"v1","content":[{"block":"video","modifiers":[],"attributes":{"videoProvider":"youtube"}}]}', $this->asJmsText($item));
        $this->assertEquals('<object data-video-provider="youtube"><embed /></object>', $this->asHtmlText($item));
    }

    public function testSuccessVideoSrcAttribute()
    {
        $item = new JMSVideoBlock();
        $item->setVideoSrc('https://www.youtube.com/video/1');
        $this->assertEquals('{"version":"v1","content":[{"block":"video","modifiers":[],"attributes":{"videoSrc":"https://www.youtube.com/video/1"}}]}', $this->asJmsText($item));
        $this->assertEquals('<object data-video-src="https://www.youtube.com/video/1"><embed /></object>', $this->asHtmlText($item));
    }

    /**
     * @param JMSAbstractBlock $item
     * @return string
     */
    private function asJmsText($item)
    {
        return $this->jmsParser->toContent((new JMSCollectionBlock())->addBlock($item));
    }

    private function asHtmlText($item)
    {
        return $this->htmlParser->toContent((new JMSCollectionBlock())->addBlock($item));
    }
}
