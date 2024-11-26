<?php

namespace App\Controllers;

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        try {
            extract($data);
            require_once APP_ROOT . "/views/{$view}.php";
        } catch (\Throwable $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
            echo "View not found.";
        }
    }

    protected function getRequestData(?array $fields = null): array
    {
        $data = [];

        if ($fields) {
            foreach ($fields as $field) {
                $data[$field] = filter_input(INPUT_POST, $field, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $data;
    }

    protected function redirect(string $path): void
    {
        header("Location: " . APP_URL . "{$path}");
        exit;
    }
}