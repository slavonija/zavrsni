<?php

use App\Exceptions\HttpNotFoundException;
use App\Services\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    protected function setUp(): void
    {
        $_SERVER['REQUEST_METHOD'] = '';
        $_SERVER['REQUEST_URI'] = '';
    
    }

    public function testGetInstance()
    {
        $router1 = Router::getInstance();
        $router2 = Router::getInstance();

        $this->assertSame($router1, $router2);
    }

    public function testDispatchSuccess()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = APP_PATH . '/test';

        $router = Router::getInstance();
        $router->get('/test', TestController::class, 'testAction');
        
        $this->expectOutputString('Test Action');
        $router->dispatch();
    }

    public function testDispatchFail()
    {
        $this->expectException(HttpNotFoundException::class);

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = APP_PATH . '/nonexist';

        $router = Router::getInstance();
        $router->get('/test1', TestController::class, 'testAction');
        
        $router->dispatch();
    }
}

class TestController
{
    public function testAction()
    {
        echo 'Test Action';
    }
}