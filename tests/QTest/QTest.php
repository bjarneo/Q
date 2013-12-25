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

namespace QTest;
require_once('../vendor/autoload.php');
use \Q\Q;

class QTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->Q = new Q(array(
            'mode' => 'development',         // 'production' for no error messages
            'view_path' => './app/View/'    // Set view folder.
        ));
    }

    public function testHasPropertyMode()
    {
        $this->assertClassHasAttribute('mode', '\Q\Q');
    }

    public function testHasPropertyView()
    {
        $this->assertClassHasAttribute('view', '\Q\Q');
    }

    public function testHasPropertyTemplatePath()
    {
        $this->assertClassHasAttribute('templatePath', '\Q\Q');
    }

    public function testRoute()
    {
        $this->Q->route('/test', function () { echo 'hello world1'; });

        // Check if paths has path
        $this->assertContains('/test', \PHPUnit_Framework_Assert::readAttribute($this->Q, 'paths'));

        // Check if callbacks has functions
        $this->assertInternalType('array', \PHPUnit_Framework_Assert::readAttribute($this->Q, 'callbacks'));
        foreach(\PHPUnit_Framework_Assert::readAttribute($this->Q, 'callbacks') as $callback) {
            if(is_callable($callback)) {
                $this->assertTrue(TRUE);
            } else {
                $this->assertTrue(FALSE);
            }
        }
    }
}

?>