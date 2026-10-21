<?php
// ========================================================
// Session y Flash Helpers - Florería Tulisol
// ========================================================

class Session {
    public static function init(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function setFlash(string $type, string $message): void {
        $_SESSION['flash'][$type] = $message;
    }

    public static function getFlash(string $type): ?string {
        if (isset($_SESSION['flash'][$type])) {
            $msg = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $msg;
        }
        return null;
    }

    public static function hasFlash(string $type): bool {
        return isset($_SESSION['flash'][$type]);
    }

    public static function setUser(array $user): void {
        $_SESSION['admin_user'] = $user;
    }

    public static function getUser(): ?array {
        return $_SESSION['admin_user'] ?? null;
    }

    public static function isLoggedIn(): bool {
        return isset($_SESSION['admin_user']);
    }

    public static function logout(): void {
        unset($_SESSION['admin_user']);
    }

    public static function csrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrfToken(?string $token): bool {
        if (empty($token) || empty($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
