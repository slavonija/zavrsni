<?php

namespace App\Models;

use App\Services\Database;
use App\Contracts\ModelInterface;

abstract class Model implements ModelInterface
{
    protected Database $db;
    protected string $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all(): array
    {
        return $this->db->table($this->table)->get();
    }
}
