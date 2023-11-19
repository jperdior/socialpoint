<?php

declare(strict_types=1);

namespace SP\Infrastructure\Data;

class DatasetStorage
{
    private static $dataset = [];

    public static function getDataset(): array
    {
        return self::$dataset;
    }

    public static function updateDataset(array $newDataset): void
    {
        self::$dataset = $newDataset;
    }
}
