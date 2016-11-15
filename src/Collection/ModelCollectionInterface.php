<?php

declare(strict_types=1);

namespace Chubbyphp\Model\Collection;

use Chubbyphp\Model\ModelInterface;

interface ModelCollectionInterface extends \Iterator, \JsonSerializable
{
    /**
     * @param ModelInterface[]|array $models
     */
    public function set(array $models);

    /**
     * @return ModelInterface[]|array
     */
    public function toPersist(): array;

    /**
     * @return ModelInterface[]|array
     */
    public function toRemove(): array;
}
