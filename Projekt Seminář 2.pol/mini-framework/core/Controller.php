<?php

abstract class Controller
{
    /**
     * Render a view file with optional data.
     *
     * @param string $view   Dot-notation path, e.g. 'users.index' → app/Views/users/index.php
     * @param array  $data   Variables to extract into the view
     * @param string $layout Layout file name inside app/Views/layouts/
     */
    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        // Convert dot notation to path
        $viewPath = BASE_PATH . '/app/Views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            throw new RuntimeException("View not found: {$viewPath}");
        }

        // Extract variables into scope
        extract($data, EXTR_SKIP);

        // Buffer the view content
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Render inside layout if one is specified
        if ($layout) {
            $layoutPath = BASE_PATH . '/app/Views/layouts/' . $layout . '.php';
            if (!file_exists($layoutPath)) {
                throw new RuntimeException("Layout not found: {$layoutPath}");
            }
            require $layoutPath;
        } else {
            echo $content;
        }
    }

    /**
     * Send a JSON response.
     */
    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Redirect to another URL.
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Get a POST or GET parameter safely.
     */
    protected function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    /**
     * Flash a message to the session.
     */
    protected function flash(string $type, string $message): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['flash'][$type] = $message;
    }
}
