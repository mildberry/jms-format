<?php

namespace Mildberry\JMSFormat\Item;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Mildberry\JMSFormat\Exception\BadBlockTypeForAddToCollection;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class CollectionItem extends AbstractItem implements IteratorAggregate , ArrayAccess, Countable
{
    /**
     * @var AbstractItem[]
     */
    protected $items = [];

    /**
     * @var string[]
     */
    protected $allowedBlocks = [];

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

        foreach ($this->items as $item) {
            $items[] = $item->asJMSArray();
        }

        return $items;
    }

    /**
     * Push an item onto the end of the collection.
     *
     * @param  AbstractItem $item
     * @return $this
     * @throws BadBlockTypeForAddToCollection
     */
    public function push(AbstractItem $item)
    {
        if (!empty($this->allowedBlocks) && !in_array($item->getBlockName(), $this->allowedBlocks)) {
            throw new BadBlockTypeForAddToCollection('Block class '.$item->getBlockName().' not allowed to add this collection');
        }

        $this->offsetSet(null, $item);

        return $this;
    }

    /**
     * @param AbstractItem $item
     * @return $this
     */
    public function unshift(AbstractItem $item)
    {
        array_unshift($this->items, $item);

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
        return json_encode($this->items, $options);
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
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
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
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
        unset($this->items[$key]);
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
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
        return new ArrayIterator($this->items);
    }
}
