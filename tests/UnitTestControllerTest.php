<?php
/* 
This is an example of how to implement unit test into your application.
Feel free to try using PHP 8+ or PHP 5.3 legacy version below. 

@author Victor Béser
*/

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../app/controllers/UnitTestController.php';

class UnitTestControllerTest extends TestCase
{
    public function testSum()
    {
        $calc = new UnitTestController();
        $this->assertEquals(4, $calc->sum(2, 2));
    }
}


// Use this for PHP 5.3 legacy
// class UnitTestControllerTest extends PHPUnit_Framework_TestCase {
//     public function testSomar() {
//         $calc = new UnitTestController();
//         $this->assertEquals(4, $calc->sum(2, 2));
//     }
// }
