<?php

namespace Mildberry\JMSFormat\Item;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * @author Egor Zyuskin <e.zyuskin@mildberry.com>
 */
class CollectionItem extends AbstractContentItem implements IteratorAggregate , ArrayAccess, Countable
{
    /**
     * @var AbstractItem[]
     */
    protected $items = [];

    /**
     * @param string|array $content
     */
    public function __construct($content = '')
    {
        if (is_array($content)) {
            $this->items = $content;
            $content = '';
        }

        parent::__construct($content);
    }

    /**
     * @return array
     */
    public function asJMSArray()
    {
        return array_merge(
            parent::asJMSArray(),
            [
                'content' => ($this->count() > 0) ? $this->getContentAsJMSArray() : $this->getContent(),
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
     * @param  AbstractItem  $value
     * @return $this
     */
    public function push(AbstractItem $value)
    {
        $this->offsetSet(null, $value);

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
