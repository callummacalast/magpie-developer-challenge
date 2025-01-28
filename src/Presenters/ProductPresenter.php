<?php

namespace App\Presenters;

use App\Product;

class ProductPresenter
{
    public function present(?array $products): string
    {
        return json_encode(
            $this->formatData($products),
            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
    }

    private function formatData(?array $products): array
    {
        return array_map(function (Product $product) {
            return [
                'title' => $product->getTitle() . ' ' . trim(
                    str_replace(' ', '', $product->getCapacityMB())
                ),
                'price' => floatval($this->removeCharacters('£', $product->getPrice())),
                'imageUrl' => $this->removeRegex('/\.\.\//', $product->getImageUrl()),
                'capacityMB' => $this->convertGbtoMb($product->getCapacityMB()),
                'color' => $product->getColour(),
                'availabilityText' => trim(
                    str_replace(
                        'Availability:',
                        '',
                        $product->getAvailabilityText()
                    )
                ),
                'isAvailable' => !str_contains($product->getAvailabilityText(), 'Out'),
                'shippingText' => $this->splitDateAndText($product->getShippingText())['text'],
                'shippingDate' => $this->splitDateAndText($product->getShippingDate())['date']
            ];
        }, $products);
    }

    private function convertGbtoMb(string $gb): ?int
    {
        if (empty($gb)) {
            return null;
        }

        if (str_contains($gb, 'MB')) {
            return $this->stripLetters($gb);
        }

        return (int)$gb * 1000;
    }

    private function stripLetters(string $string): ?string
    {
        return preg_replace('/[^0-9]/', '', $string);
    }


    private function removeCharacters(string $characters, string $string): ?string
    {
        if (empty($string)) {
            return null;
        }

        return str_replace($characters, '', $string);
    }



    private function removeRegex(string $regex, string $string): ?string
    {
        if (empty($string)) {
            return null;
        }

        return preg_replace($regex, '', $string);
    }

    private function splitDateAndText($text): ?array
    {
        // Check if the text contains numbers
        if (!preg_match('/\d/', $text) > 0) {
            return [
                'date' => null,
                'text' => $text
            ];
        }

        // Try to match a date like "2025-01-28"
        if (preg_match('/\d{4}-\d{2}-\d{2}/', $text, $matches)) {
            return [
                'date' => $matches[0],
                'text' => $text
            ];
        }

        // Try to match a date with day of the week (e.g., "Monday 27th Jan 2025")
        if (preg_match('/\b(\w+)\s(\d{1,2})(st|nd|rd|th)?\s(\w+)\s(\d{4})\b/', $text, $matches)) {
            // roughly normalise the date and convert it to Y-m-d
            $dateStr = "{$matches[2]} {$matches[4]} {$matches[5]}";
            return [
                'date' => date('Y-m-d', strtotime($dateStr)),
                'text' => $text
            ];
        }

        // Try to match the format "have it 2025-01-29"
        if (preg_match('/have it (\d{4}-\d{2}-\d{2})/', $text, $matches)) {
            return [
                'date' => $matches[1],
                'text' => $text
            ];
        }

        return null;
    }
}
