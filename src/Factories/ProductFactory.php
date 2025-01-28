<?php

namespace App\Factories;

use App\Product;

class ProductFactory
{
    public function fromArray(?array $productData): ?Product
    {
        if (empty($productData)) {
            return null;
        }

        $product = new Product;

        $product->setTitle($productData['title'] ?? null);
        $product->setPrice($productData['price'] ?? null);
        $product->setImageUrl($productData['imageUrl'] ?? null);
        $product->setCapacityMB($productData['capacityGB'] ?? null);
        $product->setColour($productData['color'] ?? null);
        $product->setAvailabilityText($productData['availabilityText'] ?? null);
        $product->setIsAvailable($productData['isAvailable'] ?? null);
        $product->setShippingText($productData['shippingText'] ?? null);
        $product->setShippingDate($productData['shippingDate'] ?? null);

        return $product;
    }
}
