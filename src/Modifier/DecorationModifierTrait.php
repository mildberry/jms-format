<?php

namespace Mildberry\JMSFormat\Modifier;

use Mildberry\JMSFormat\Exception\BadModifierValueException;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
trait DecorationModifierTrait
{
    /**
     * @var array
     */
    protected $decoration = [];
    
    /**
     * @return array
     */
    public function getDecoration()
    {
        return (!empty($this->decoration)) ? $this->decoration : null;
    }

    /**
     * @param string|array $decoration
     * @return $this
     * @throws BadModifierValueException
     */
    public function setDecoration($decoration)
    {
        if (is_array($decoration)) {
            $this->decoration = $decoration;
        } else {
            if (!in_array($decoration, $this->getDecorationAllowedValues())) {
                throw new BadModifierValueException('Decoration value: "' . $decoration . '" not valid, must be [' . implode(', ', $this->getDecorationAllowedValues()) . ']');
            }
            array_push($this->decoration, $decoration);
        }

        $this->decoration = array_unique($this->decoration);
        $this->tagName = $this->getDecorationTags()[$this->decoration[0]];

        return $this;
    }

    /**
     * @return string
     */
    public function getDecorationHtmlClass()
    {
        if (!$decorations = $this->getDecoration()) {
            return null;
        }

        if (($key = array_search($this->getDecorationByTag($this->tagName), $decorations)) !== false) {
            unset($decorations[$key]);
        }

        $classes = [];

        foreach ($decorations as $decoration) {
            $classes[] = 'decoration-'.$decoration;
        }

        return (!empty($classes)) ? implode(' ', $classes) : null;
    }

    /**
     * @return array
     */
    public function getDecorationAllowedValues()
    {
        return array_keys($this->getDecorationTags());
    }

    /**
     * @param string $tagName
     * @return string
     */
    public function getDecorationByTag($tagName)
    {
        return array_search($tagName, $this->getDecorationTags());
    }

    /**
     * @return array
     */
    private function getDecorationTags()
    {
        return [
            'bold' => 'b',
            'italic' => 'i',
            'del' => 'del',
            'underline' => 'u',
        ];
    }
}
