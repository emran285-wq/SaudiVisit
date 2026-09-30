<?php
/** Admin authentication & role checks (server-side least privilege per PRD). */

declare(strict_types=1);

function auth_start(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        ini_set('session.use_strict_mode', '1');
        session_set_cookie_params([
            'path' => BASE_PATH !== '' ? BASE_PATH . '/' : '/',
            'httponly' => true,
            'samesite' => 'Lax',
            'secure' => APP_FORCE_HTTPS || ((!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off') || (int)($_SERVER['SERVER_PORT'] ?? 0) === 443),
        ]);
        session_start();
    }
}

function current_user(): ?array
{
    auth_start();
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    $row = q('SELECT id, email, name, role FROM users WHERE id = ?', [$_SESSION['user_id']])->fetch();
    return $row ?: null;
}

function require_login(): array
{
    $user = current_user();
    if (!$user) {
        redirect(BASE_PATH . '/admin/login.php');
    }
    return $user;
}

function require_role(array $user, string ...$roles): void
{
    if (!in_array($user['role'], $roles, true)) {
        http_response_code(403);
        exit('Forbidden: insufficient permissions.');
    }
}

/** Writers may only touch their own drafts (PRD role rules). */
function can_edit_article(array $user, array $article): bool
{
    if (in_array($user['role'], ['admin', 'editor'], true)) {
        return true;
    }
    return $user['role'] === 'writer' && (int)($article['owner_id'] ?? 0) === (int)$user['id'];
}

function can_publish(array $user): bool
{
    return in_array($user['role'], ['admin', 'editor'], true);
}

function attempt_login(string $email, string $password): ?array
{
    auth_start();
    // Simple rate limit: 5 attempts per 10 minutes per session
    $_SESSION['login_attempts'] = array_filter(
        $_SESSION['login_attempts'] ?? [],
        fn ($t) => $t > time() - 600
    );
    if (count($_SESSION['login_attempts']) >= 5) {
        return null;
    }
    $_SESSION['login_attempts'][] = time();

    $user = q('SELECT * FROM users WHERE email = ?', [strtolower(trim($email))])->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        unset($_SESSION['login_attempts']);
        audit((int)$user['id'], 'login', 'user', (int)$user['id']);
        return $user;
    }
    return null;
}

function logout(): void
{
    auth_start();
    $_SESSION = [];
    session_destroy();
}
