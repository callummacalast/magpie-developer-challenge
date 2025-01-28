<?php

namespace App;

use App\Presenters\ProductPresenter;

require 'vendor/autoload.php';

class Scrape
{
    private array $products = [];
    private ?string $baseUrl = 'https://www.magpiehq.com/developer-challenge';
    private ScrapeHelper $scrapeHelper;
    private ProductPresenter $productPresenter;

    public function __construct()
    {
        $this->scrapeHelper = new ScrapeHelper($this->baseUrl);
        $this->productPresenter = new ProductPresenter();
    }

    public function run(): void
    {
        try {
            $document = ScrapeHelper::fetchDocument($this->baseUrl . '/smartphones');
            $pageLinks = $document->filter('#pages > div > a');

            foreach ($pageLinks as $pageLink) {
                $this->products = array_merge(
                    $this->products,
                    $this->scrapeHelper->scrapePage(
                        ScrapeHelper::fetchDocument($this->baseUrl . '/smartphones/?page=' . trim($pageLink?->textContent))
                    )
                );
            }

            file_put_contents(
                'output.json',
                $this->productPresenter->present(array_values($this->products))
            );

            Logger::log('Success! Output written to output.json');
        } catch (\Throwable $th) {
            Logger::log($th->getMessage() . PHP_EOL . $th->getTraceAsString(), 'error');
        }
    }
}

$scrape = new Scrape();
$scrape->run();
