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

class Request
{
    protected $request;

    /**
     * Set request uri
     * @param $request
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get Request URI
     * @return array
     */
    public function getRequest()
    {
        $requests = array();


        // Explode requests
        $requests = explode('/', $this->request);
        // Remove empty array elements and rearrange keys
        $requests = array_values(
            array_filter($requests)
        );

        // Add slash if empty
        if(!$requests) {
            $requests[0] = '/';
        }

        return $this->filterRequest($requests);
    }

    /**
     * Filter request paths
     * @param array $requests
     * @return array
     */
    protected function filterRequest(array $requests = array())
    {
        $output = array();

        // Set path output (works with only one 'segment'. Example /code)
        foreach($requests as $request) {
            if($request !== 'index.php' && $request !== '/') {
                // Set our path
                $output['path'] = '/' . $request;

                // Generate our params
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
}

?>