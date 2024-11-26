<?php

namespace App\Models;

class User extends Model
{
    protected string $table = 'users';

    public function create(array $data): bool|int
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        return 
            $this->db
                ->table($this->table)
                ->insert($data);
    }

    public function findByEmail(string $email): ?array
    {
        return 
            $this->db
                ->table($this->table)
                ->where('email', $email)
                ->first();
    }
}