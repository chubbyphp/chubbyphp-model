<?php

declare(strict_types=1);

namespace Chubbyphp\Model\Cache;

final class ModelCache implements ModelCacheInterface
{
    /**
     * @var array
     */
    private $cache = [];

    /**
     * @param string $id
     * @param array  $row
     *
     * @return ModelCacheInterface
     */
    public function set(string $id, array $row): ModelCacheInterface
    {
        $this->cache[$id] = $row;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->cache);
    }

    /**
     * @param string $id
     *
     * @return array
     *
     * @throws RowNotFoundException
     */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw RowNotFoundException::fromId($id);
        }

        return $this->cache[$id];
    }

    /**
     * @param string $id
     *
     * @return ModelCacheInterface
     */
    public function remove(string $id): ModelCacheInterface
    {
        unset($this->cache[$id]);

        return $this;
    }
}
