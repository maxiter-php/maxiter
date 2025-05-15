<?php
/* 
This is an example of how to implement unit test into your application.
Feel free to try using PHP 8+ or PHP 5.3 legacy version below. 

@author Victor Béser
*/

define('PHPUNIT_RUNNING', true);
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../app/controllers/UnitTestController.php';

class UnitTestControllerTest extends TestCase
{
    public function testPostSum()
    {
        $_POST["a"] = 3;
        $_POST["b"] = 7;

        $controller = new UnitTestController();

        ob_start();
        $controller->postSum();
        $output = ob_get_clean();

        $this->assertJson($output);

        $expected = json_encode(array(
            "status" => true,
            "data" => 10
        ));

        $this->assertEquals($expected, $output);
    }

}


// Try this for PHP 5.3 legacy and check out the version of PHPUnit in composer.json
// class UnitTestControllerTest extends PHPUnit_Framework_TestCase {
//     public function testSomar() {
//         $calc = new UnitTestController();
//         $this->assertEquals(4, $calc->sum(2, 2));
//     }
// }
