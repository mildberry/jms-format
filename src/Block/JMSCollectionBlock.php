<?php

namespace Mildberry\JMSFormat\Block;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Mildberry\JMSFormat\Exception\BadBlockTypeForAddToCollection;
use Mildberry\JMSFormat\JMSBlockHelper;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class JMSCollectionBlock extends JMSAbstractBlock implements IteratorAggregate , ArrayAccess, Countable
{
    /**
     * @var string
     */
    protected $blockName = 'body';

    /**
     * @var JMSAbstractBlock[]
     */
    protected $blocks = [];

    /**
     * @var string[]
     */
    protected $allowedBlocks = [];

    /**
     * @param array $data
     * @return $this
     */
    public function loadFromJMSArray(array $data)
    {
        parent::loadFromJMSArray($data);

        if (!empty($data['content'])) {
            foreach ($data['content'] as $blockData) {
                $block = JMSBlockHelper::createBlockByName($blockData['block']);
                $block->loadFromJMSArray($blockData);
                $this->addBlock($block);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function asJMSArray()
    {
        return array_merge(
            parent::asJMSArray(),
            [
                'content' => $this->getContentAsJMSArray(),
            ]
        );
    }

    /**
     * @return array
     */
    public function getContentAsJMSArray()
    {
        $items = [];

        foreach ($this->blocks as $item) {
            $items[] = $item->asJMSArray();
        }

        return $items;
    }

    /**
     * Push an item onto the end of the collection.
     *
     * @param  JMSAbstractBlock $item
     * @return $this
     * @throws BadBlockTypeForAddToCollection
     */
    public function addBlock(JMSAbstractBlock $item)
    {
        if (!empty($this->allowedBlocks) && !in_array($item->getBlockName(), $this->allowedBlocks)) {
            throw new BadBlockTypeForAddToCollection('Block class '.$item->getBlockName().' not allowed to add this collection');
        }

        $this->offsetSet(null, $item);

        return $this;
    }

    /**
     * @param JMSCollectionBlock $collection
     * @return $this
     */
    public function addCollection(JMSCollectionBlock $collection)
    {
        $this->blocks = array_merge($this->blocks, $collection->getBlocks());

        return $this;
    }

    /**
     * @param JMSAbstractBlock $item
     * @return $this
     */
    public function insertFirstBlock(JMSAbstractBlock $item)
    {
        array_unshift($this->blocks, $item);

        return $this;
    }

    /**
     * Get the collection of items as JSON.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->asJMSArray(), $options);
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->blocks);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->blocks[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->blocks[] = $value;
        } else {
            $this->blocks[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->blocks[$key]);
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->blocks);
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Get an iterator for the items.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->blocks);
    }

    /**
     * @return JMSAbstractBlock[]
     */
    public function getBlocks()
    {
        return $this->blocks;
    }
}
