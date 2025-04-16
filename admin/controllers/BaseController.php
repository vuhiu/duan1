<?php
class BaseController
{
    protected function loadView($viewPath, $data = [])
    {
        // Extract data array to individual variables
        extract($data);

        // Define the full path to the view file
        $viewFile = __DIR__ . '/../views/' . $viewPath . '.php';

        // Check if view file exists
        if (!file_exists($viewFile)) {
            die("View file not found: " . $viewPath);
        }

        // Include the view file
        require_once $viewFile;
    }
}
