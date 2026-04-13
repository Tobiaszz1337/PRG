<?php

class Autoloader
{
    private static array $namespaceMap = [];

    public static function register(): void
    {
        spl_autoload_register([static::class, 'load']);
    }

    public static function addNamespace(string $namespace, string $directory): void
    {
        self::$namespaceMap[$namespace] = rtrim($directory, '/');
    }

    public static function load(string $class): void
    {
        // Try namespace map first
        foreach (self::$namespaceMap as $namespace => $directory) {
            if (str_starts_with($class, $namespace)) {
                $relative = substr($class, strlen($namespace));
                $file = $directory . '/' . str_replace('\\', '/', $relative) . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        }

        // Fallback: scan known directories
        $directories = [
            BASE_PATH . '/core',
            BASE_PATH . '/app/Controllers',
            BASE_PATH . '/app/Models',
        ];

        foreach ($directories as $dir) {
            $file = $dir . '/' . $class . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
}
