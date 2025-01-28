<?php

namespace App;

use GuzzleHttp\Client;
use App\UseCases\ExtractProductFromPageUseCase;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeHelper
{
    private ExtractProductFromPageUseCase $extractProductFromPageUseCase;
    private string $url;

    public function __construct(string $url)
    {
        $this->extractProductFromPageUseCase = new ExtractProductFromPageUseCase();
        $this->url = $url;
    }

    public static function fetchDocument(string $url): Crawler
    {
        $client = new Client();

        $response = $client->get($url);

        return new Crawler($response->getBody()->getContents(), $url);
    }

    public function scrapePage(Crawler $page): ?array
    {
        $productWrapper = $page->filter('#products > div');
        $products = $productWrapper->filter('.product');

        $productsPerPage = [];

        foreach ($products as $product) {
            $product = new Crawler($product);

            $colorNodes = $product->filter('span[data-colour]');

            foreach ($colorNodes as $colorNode) {
                $colorNode = new Crawler($colorNode);

                $productData = $this->extractProductFromPageUseCase
                    ->handle($product, $this->url);

                $productData->setColour($colorNode->attr('data-colour'));

                $uuid = $productData->getTitle() . '_' . $productData->getColour() . '_' . $productData->getCapacityMB();

                $productsPerPage[$uuid] = $productData;
            }
        }

        return $productsPerPage;
    }
}
