<?php
/**
 * Q - a PHP5 Framework
 *
 * @author      Bjarne Øverli <http://www.twitter.com/bjarneo_>
 * @copyright   2013 Bjarne Øverli
 * @link        https://github.com/bjarneo/Q
 * @version     0.1.0
 * @package     View
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

namespace Q\View;
class View
{
    /**
     * Template to render
     * @var
     */
    private $_template;

    /**
     * Data
     * @var
     */
    private $_data;


    /**
     * Set our template
     * @param $template
     * @param $data
     */
    public function __construct($template, array $data)
    {
        $this->_data = $data;

        try {
            if(file_exists($template)) {
                $this->_template = $template;
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Render the view
     * @return string
     */
    public function view()
    {
        $html = false;

        if(isset($this->_data)) {
            extract($this->_data);
        }

        ob_start();
        include($this->_template);
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}

?>