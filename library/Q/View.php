<?php
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

namespace Q;

class View
{
    /**
     * Template to render
     * @var
     */
    protected $template;

    /**
     * Data
     * @var
     */
    protected $data;

    /**
     * Set template
     * @param $template
     * @return $this
     */
    public function setTemplate($template)
    {
        try {
            if(file_exists($template)) {
                $this->template = $template;
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    /**
     * Get template
     * @return $template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set data
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Return data
     * @return $data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Render the view
     * @return string $html Html output
     */
    public function render()
    {
        $html = false;

        // Extract template data
        if(isset($this->data)) {
            extract($this->data);
        }

        // Start ouput buffering and compress it with ob_gzhandler
        ob_start('ob_gzhandler');
        include($this->template);
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}

?>