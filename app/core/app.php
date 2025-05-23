<?php
namespace App\Core;

/**
 * The main application class responsible for routing.
 */
class app
{
    /**
     * The controller to be loaded. Defaults to '_404'.
     * @var string
     */
    protected $controller = '_404';

    /**
     * The method to be called in the controller. Defaults to 'index'.
     * @var string
     */
    protected $method = 'index';

    /**
     * Holds the current page/controller name for global access.
     * @var string
     */
    public static $page = '_404';

    /**
     * Constructor: Parses the URL, loads the appropriate controller and method, and executes it.
     */
    public function __construct()
    {
        $arr = $this->geturl();
        $filename = "../app/controller/" . ucfirst($arr[0]) . ".php";

        if (file_exists($filename)) {
            require $filename;
            $this->controller = $arr[0];
            self::$page = $arr[0];
            unset($arr[0]);
        } else {
            require "../app/controller/" . $this->controller . ".php";
        }

        $myController = new $this->controller();
        $myMethod = $arr[1] ?? $this->method;

        if (!empty($arr[1]) && method_exists($myController, strtolower($myMethod))) {
            $this->method = strtolower($myMethod);
            unset($arr[1]);
        }

        $arr = array_values($arr);
        call_user_func_array([$myController, $this->method], $arr);
    }

    /**
     * Parses the URL and returns its components as an array.
     *
     * @return array URL segments.
     */
    private function geturl(): array
    {
        $url = $_GET['url'] ?? 'home';
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $arr = explode('/', $url);
        return $arr;
    }
}
