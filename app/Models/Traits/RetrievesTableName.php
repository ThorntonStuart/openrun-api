<?php

namespace App\Models\Traits;

trait RetrievesTableName
{
    /**
     * Get table name of model statically
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return (new self())->getTable();
    }
}