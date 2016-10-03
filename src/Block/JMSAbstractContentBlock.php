<?php

namespace Mildberry\JMSFormat\Block;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
abstract class JMSAbstractContentBlock extends JMSAbstractBlock
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->setContent($content);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function loadFromJMSArray(array $data)
    {
        parent::loadFromJMSArray($data);

        $this->setContent($data['content']);
    }

    /**
     * @return array
     */
    public function asJMSArray()
    {
        return array_merge(
            parent::asJMSArray(),
            [
                'content' => $this->getContent(),
            ]
        );
    }
}
