<?php
// ========================================================
// User Model - Florería Tulisol
// ========================================================

class User extends Model {
    protected string $table = 'users';

    public function findByEmail(string $email): ?array {
        return $this->findBy('email', trim(strtolower($email)));
    }

    public function verifyPassword(string $plainPassword, string $hash): bool {
        return password_verify($plainPassword, $hash);
    }

    public function updatePassword(int $userId, string $newPassword): bool {
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        return $this->update($userId, ['password' => $hash]);
    }
}
