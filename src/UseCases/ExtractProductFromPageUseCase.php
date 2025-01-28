<?php

namespace App\UseCases;

use App\Factories\ProductFactory;
use App\Product;
use Symfony\Component\DomCrawler\Crawler;

class ExtractProductFromPageUseCase
{
    private ProductFactory $productFactory;

    public function __construct()
    {
        $this->productFactory = new ProductFactory();
    }

    public function handle(Crawler $productNodes, string $url): ?Product
    {
        $availabilityAndShipping = $productNodes->filter('div > div > div.my-4.text-sm.block.text-center');

        $productData = [
            'title' => $productNodes->filter('span.product-name')->text(),
            'price' => $productNodes->filter('div > div > div:contains("£")')->text(),
            'imageUrl' => $url . '/' . $productNodes->filter('img')->attr('src'),
            'capacityGB' => $productNodes->filter('h3 > .product-capacity')->text(),
            'availabilityText' => $availabilityAndShipping->first()->text(),
            'isAvailable' => $availabilityAndShipping->first()->text(),
            'shippingText' => $availabilityAndShipping->count() === 1 ? null : $availabilityAndShipping->last()->text(),
            'shippingDate' => $availabilityAndShipping->count() > 1 ?  $availabilityAndShipping->last()->text() : ""
        ];

        return $this->productFactory->fromArray($productData);
    }
}
