<?php


namespace app\tests\Unit;


use app\core\Database;
use app\core\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    function testCanOpenIndexPage()
    {
        $router = new Router(true);
        $router->add('', ['controller' => 'IndexController', 'action' => 'index']);
        $result = $router->dispatch('/');
        $this->assertTrue($result);
    }

    function testCantOpenNonexistPage()
    {
        $this->expectException(\Exception::class);
        $router = new Router();
        $router->dispatch('/non-exist');
    }
}
