<?php
namespace App\Core;

/**
 * Main controller class.
 * Provides a method to render view files and pass data to them.
 */
class Controller
{
    /**
     * Load a view file and pass data to it.
     *
     * @param string $view The name of the view file (without "View.php" suffix).
     * @param array $data Associative array of data to extract as variables in the view.
     *
     * @return void
     */
    public function view($view, $data = []): void
    {
        extract($data);
        $filename = "../app/view/" . $view . "View.php";
        if (file_exists($filename)) {
            require $filename;
        } else {
            echo "Could not find view file: " . $filename;
        }
    }
}
