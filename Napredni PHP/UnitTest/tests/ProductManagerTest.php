<?php

use PHPUnit\Framework\TestCase;
use Administrator\UnitTests\ProductManager;

class ProductManagerTest extends TestCase
{
    private $productManager;

    protected function setUp(): void
    {
        $this->productManager = new ProductManager();
    }

    public function testGetAllProducts()
    {
        $this->productManager->addProduct('A1', 'Product 1', 10.0);
        $this->productManager->addProduct('A2', 'Product 2', 20.0);
        $products = $this->productManager->getAllProducts();

        $this->assertCount(2, $products);
        $this->assertArrayHasKey('A1', $products);
        $this->assertArrayHasKey('A2', $products);
    }

    public function testAddProduct()
    {
        $this->productManager->addProduct('A1', 'Product 1', 10.0);

        $this->assertArrayHasKey('A1', $this->productManager->getAllProducts());
        $this->assertIsArray($this->productManager->getProduct('A1'));

    }

    public function testAddProductWithExistingId()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Product with this ID already exists.');

        $this->productManager->addProduct('A1', 'Product 1', 10.0);
        $this->productManager->addProduct('A1', 'Product 2', 20.0);
    }
}