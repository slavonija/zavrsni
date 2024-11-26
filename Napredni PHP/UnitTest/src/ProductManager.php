<?php

namespace Administrator\UnitTests;

use  Exception;

class ProductManager
{
    private array $products = [];

    /**
     * Adds a product to the inventory.
     *
     * @param string $id Unique identifier for the product
     * @param string $name Name of the product
     * @param float $price Price of the product
     */
    public function addProduct($id, $name, $price)
    {
        if (isset($this->products[$id])) {
            throw new Exception("Product with this ID already exists.");
        }

        $this->products[$id] = [
            'name' => $name,
            'price' => $price
        ];
    }

    /**
     * Updates an existing product.
     *
     * @param string $id Product identifier
     * @param string $name New name of the product
     * @param float $price New price of the product
     */
    public function updateProduct($id, $name, $price)
    {
        if (!isset($this->products[$id])) {
            throw new Exception("Product not found.");
        }

        $this->products[$id] = [
            'name' => $name,
            'price' => $price
        ];
    }

    /**
     * Removes a product from the inventory.
     *
     * @param string $id Product identifier
     */
    public function removeProduct($id)
    {
        if (!isset($this->products[$id])) {
            throw new Exception("Product not found.");
        }

        unset($this->products[$id]);
    }

    /**
     * Retrieves a product by its ID.
     *
     * @param string $id Product identifier
     * @return array|null
     */
    public function getProduct($id)
    {
        if (!isset($this->products[$id])) {
            return null;
        }

        return $this->products[$id];
    }

    /**
     * Returns all products.
     *
     * @return array
     */
    public function getAllProducts()
    {
        return $this->products;
    }
}