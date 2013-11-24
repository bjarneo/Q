<?php
require_once('lib/View.php');
/**
 * Q - a PHP5 Framework
 *
 * @author      Bjarne Øverli <http://www.twitter.com/bjarneo_>
 * @copyright   2013 Bjarne Øverli
 * @link        https://github.com/bjarneo/Q
 * @version     0.1.0
 * @package     Q
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
class Q
{
    /**
     * Template path
     * @var string
     */
    public $templatePath;

    /**
     * Developement / Production
     * @var string
     */
    protected $mode;

    /**
     * Constructor
     * Set default config
     * @param config
     */
    public function __construct($config = false)
    {
        $this->templatePath = ($config['view_path']) ? $config['view_path'] : './app/View/';
        $this->mode = ($config['mode']) ? $config['mode'] : 'developement';

        // Run error management
        $this->error();
    }

    /**
     * Create our route
     * @param $path
     * @param $callback
     * @return bool
     */
    public function route($path, $callback)
    {
        if(isset($_SERVER['PATH_INFO']) && $path !== $_SERVER['PATH_INFO']) {
            return false;
        }

        if($_SERVER['PATH_INFO'] === $path || $_SERVER['REQUEST_URI'] === $path) {
            call_user_func($callback);
        } elseif($_SERVER['REQUEST_URI'] === $path && $path === '/') {
            call_user_func($callback);
        }
        /*
        if(strpos($path, ':')) {

        }
        */
    }

    /**
     * Render template
     * @param $template
     * @param bool $data
     */
    public function render($template, $data = array())
    {
        $view = new View($this->templatePath . $template, $data);
        echo $view->view();
    }

    private function error()
    {
        switch(strtolower($this->mode)) {
            case 'developement':
                error_reporting(E_ALL);
                break;
            case 'production':
                error_reporting(0);
                break;
            default:
                error_reporting(E_ERROR | E_WARNING | E_PARSE);
        }
    }
}

?>