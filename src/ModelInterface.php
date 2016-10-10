<?php

declare(strict_types=1);

namespace Chubbyphp\Model;

interface ModelInterface
{
    /**
     * @param array $data
     *
     * @return ModelInterface
     */
    public static function fromRow(array $data): ModelInterface;

    /**
     * @return array
     */
    public function toRow(): array;

    /**
     * @return string
     */
    public function getId(): string;
}
