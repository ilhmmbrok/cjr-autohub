<?php

namespace App\Models;

use App\Core\Database;

class UserModel
{
    protected string $table = 'users';

    public function findByEmail(string $email): array|false
    {
        return Database::fetch("SELECT * FROM {$this->table} WHERE email = ?", [$email]);
    }

    public function findById(int $id): array|false
    {
        return Database::fetch("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function getAll(): array
    {
        return Database::fetchAll("SELECT * FROM {$this->table}");
    }

    public function create(array $data): int
    {
        return Database::execute(
            "INSERT INTO {$this->table} (fullname, email, password, role)
             VALUES (?, ?, ?, ?)",
            [
                $data['fullname'],
                $data['email'],
                $data['password'],
                $data['role'] ?? 'customer',
            ]
        );
    }

    public function update(int $id, array $data): int
    {
        return Database::execute(
            "UPDATE {$this->table} SET fullname = ?, email = ? WHERE id = ?",
            [$data['fullname'], $data['email'], $id]
        );
    }

    /**
     * Update profil customer (fullname, email, phone).
     */
    public function updateProfile(int $id, array $data): int
    {
        return Database::execute(
            "UPDATE {$this->table} SET fullname = ?, email = ?, phone = ? WHERE id = ?",
            [$data['fullname'], $data['email'], $data['phone'] ?? null, $id]
        );
    }

    public function updatePassword(int $id, string $hashedPassword): int
    {
        return Database::execute(
            "UPDATE {$this->table} SET password = ? WHERE id = ?",
            [$hashedPassword, $id]
        );
    }

    public function delete(int $id): int
    {
        return Database::execute(
            "DELETE FROM {$this->table} WHERE id = ?",
            [$id]
        );
    }

    public function getAllCustomers(): array
    {
        return Database::fetchAll(
            "SELECT * FROM {$this->table} WHERE role = 'customer' ORDER BY created_at DESC"
        );
    }
}
