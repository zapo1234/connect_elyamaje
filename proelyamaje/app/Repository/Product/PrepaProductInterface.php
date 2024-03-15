<?php

namespace App\Repository\Product;


interface PrepaProductInterface
{
    public function getAllProducts();

    public function getAllProductsPublished();

    public function insertProductsOrUpdate($products);
}




