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
     * Cache paths
     * @array $paths
     */
    protected $paths;

    /**
     * Cache callbacks
     * @array callbacks
     */
    protected $callbacks;

    /**
     * Constructor
     * Set default config
     * @param config
     */
    public function __construct($config = false)
    {
        $this->templatePath = ($config['view_path']) ? $config['view_path'] : './app/View/';
        $this->mode = ($config['mode']) ? $config['mode'] : 'default';

        // Run error management
        $this->error();
    }

    /**
     * Route
     *
     */
    public function route($path, $callback)
    {
        $this->paths[] = $path;
        $this->callbacks[] = $callback;
    }

    /**
     * Map URI
     * @return array|bool
     */
    protected function map()
    {
        $userFuncProperties = array();
        $request = $this->requests();

        $userFuncProperties = array(
            'key' => array_search($request['path'], $this->paths),
            'params' => (isset($request['params'])) ? $request['params'] : array()
        );

        if(isset($userFuncProperties['key'])) {
            return $userFuncProperties;
        } else {
            return false;
        }
    }

    /**
     * Filter request uri
     * @return array
     */
    protected function requests()
    {
        $requests = array();
        $output = array();

        // Explode requests
        $requests = explode('/', $_SERVER['REQUEST_URI']);
        // Remove empty array elements and rearrange keys
        $requests = array_values(
            array_filter($requests)
        );

        // Add slash if empty
        if(!$requests) {
            $requests[0] = '/';
        }

        // Set path output (works with only one 'segment'. Example /code)
        foreach($requests as $request) {
            if($request !== 'index.php' && $request !== '/') {
                $output['path'] = '/' . $request;
                $output['params'] = array_values(
                    array_diff($requests, array($request))
                );
                // break after we hit first path
                break;
            } else if($request === '/') {
                $output['path'] = '/';
                break;
            }
        }

        return $output;
    }

    /**
     * Run app
     */
    public function run()
    {
        $map = $this->map();
        if(isset($map['key']) && is_numeric($map['key'])) {
            call_user_func_array($this->callbacks[$map['key']], $map['params']);
        } else {
            $this->render('404.php');
            header("HTTP/1.0 404 Not Found");
        }
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

    /**
     * Error management
     * Todo: better error management. Create own class.
     */
    protected function error()
    {
        switch(strtolower($this->mode)) {
            case 'development':
                error_reporting(E_ALL);
                break;
            case 'production':
                error_reporting(0);
                break;
            default:
                error_reporting(E_ERROR | E_WARNING | E_PARSE);
        }
    }

    /**
     * Todo: Create own logger class
     * @param $str
     * @param $array
     */
    public function log($str, $array)
    {
        echo '## ' . $str . ': ' . count($array) . ' ##<br />';
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
}

?>