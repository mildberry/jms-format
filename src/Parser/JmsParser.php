<?php

namespace Mildberry\JMSFormat\Parser;

use Mildberry\JMSFormat\Block\JMSAbstractBlock;
use Mildberry\JMSFormat\Block\JMSAbstractContentBlock;
use Mildberry\JMSFormat\Block\JMSCollectionBlock;
use Mildberry\JMSFormat\Block\JMSTextBlock;
use Mildberry\JMSFormat\Exception\BadBlockNameException;
use Mildberry\JMSFormat\Interfaces\ParserInterface;
use Mildberry\JMSFormat\JMSAttributeHelper;
use Mildberry\JMSFormat\JMSModifierHelper;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JmsParser implements ParserInterface
{
    const VERSION = 'v1';

    /**
     * @param string $content
     * @return JMSCollectionBlock
     */
    public function toCollection($content)
    {
        $collection = new JMSCollectionBlock();

        $data = json_decode($content, true);

        if (!empty($data['version']) && !empty($data['content'])) {
            $collection->addCollection($this->createBlockFromArray('collection', $data));
        }

        return $collection;
    }

    /**
     * @param JMSCollectionBlock $collection
     * @return string
     */
    public function toContent(JMSCollectionBlock $collection)
    {
        $content = [
            'version' => self::VERSION,
            'content' => $this->getArrayFromCollection($collection),
        ];

        return json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param string $name
     * @param string|array $data
     * @return JMSAbstractBlock
     */
    private function createBlockFromArray($name, $data)
    {
        $block = $this->createBlockByName($name);

        if (!empty($data['modifiers'])) {
            foreach ($data['modifiers'] as $name => $value) {
                $interfaceName = JMSModifierHelper::getModifierInterfaceClassName($name);
                $methodName = JMSModifierHelper::getModifierSetterName($name);

                if ($block instanceof $interfaceName) {
                    $block->$methodName($value);
                }
            }
        }

        if (!empty($data['attributes'])) {
            foreach ($data['attributes'] as $name => $value) {
                $interfaceName = JMSAttributeHelper::getAttributeInterfaceClassName($name);
                $attributeName = JMSAttributeHelper::getAttributeSetterName($name);

                if ($block instanceof $interfaceName) {
                    $block->$attributeName($value);
                }
            }
        }

        if (!empty($data['content'])) {
            if ($block instanceof JMSCollectionBlock) {
                if (is_array($data['content'])) {
                    foreach ($data['content'] as $blockData) {
                        $block->addBlock($this->createBlockFromArray($blockData['block'], $blockData));
                    }
                } else {
                    $block->addBlock(new JMSTextBlock($data['content']));
                }
            } elseif ($block instanceof JMSAbstractContentBlock) {
                $block->setContent($data['content']);
            }
        }

        return $block;
    }

    /**
     * @param JMSAbstractBlock $block
     * @return array
     */
    private function getArrayFromBlock($block)
    {
        $return = [
            'block' => $block->getBlockName(),
            'modifiers' => $this->getBlockModifiers($block),
        ];

        if ($attributes = $this->getBlockAttributes($block)) {
            $return['attributes'] = $attributes;
        }

        if ($block instanceof JMSAbstractContentBlock) {
            $return['content'] = $block->getContent();
        }

        if ($block instanceof JMSCollectionBlock && $content = $this->getArrayFromCollection($block)) {
            $return['content'] = $content;
        }

        return $return;
    }

    /**
     * @param JMSCollectionBlock $collectionBlock
     * @return array
     */
    private function getArrayFromCollection(JMSCollectionBlock $collectionBlock)
    {
        $return = [];

        foreach ($collectionBlock as $item) {
            $return[] = $this->getArrayFromBlock($item);
        }

        return $return;
    }

    /**
     * @param JMSAbstractBlock $block
     * @return array
     */
    private function getBlockModifiers($block)
    {
        $modifiersName = JMSModifierHelper::getAllowedModifiers();
        $modifiers = [];

        foreach ($modifiersName as $name) {
            $interfaceName = JMSModifierHelper::getModifierInterfaceClassName($name);
            $methodName = JMSModifierHelper::getModifierGetterName($name);

            if ($block instanceof $interfaceName) {
                if ($modifiersValue = $block->$methodName()) {
                    $modifiers[$name] = $modifiersValue;
                }
            }
        }

        return $modifiers;
    }

    /**
     * @param JMSAbstractBlock $block
     * @return array
     */
    public function getBlockAttributes($block)
    {
        $attributesName = JMSAttributeHelper::getAllowedAttributes();
        $attributes = [];

        foreach ($attributesName as $name) {
            $interfaceName = JMSAttributeHelper::getAttributeInterfaceClassName($name);
            $methodName = JMSAttributeHelper::getAttributeGetterName($name);

            if ($block instanceof $interfaceName) {
                if ($attributesValue = $block->$methodName()) {
                    $attributes[$name] = $attributesValue;
                }
            }
        }

        return $attributes;
    }

    /**
     * @param string $name
     * @return JMSAbstractBlock
     * @throws BadBlockNameException
     */
    private function createBlockByName($name)
    {
        $className = __NAMESPACE__ . '\\Block\\JMS' . ucfirst(strtolower($name)) . 'Block';

        if (!class_exists($className)) {
            throw new BadBlockNameException('Class from block "' . $name . '" not exists');
        }

        $block = new $className;

        if (!$block instanceof JMSAbstractBlock) {
            throw new BadBlockNameException('Class "' . $className . '" not block');
        }

        return $block;
    }
}
