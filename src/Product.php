<?php

namespace App;

class Product
{
    private ?string $title = null;
    private ?string $price = null;
    private ?string $iamgeUrl = null;
    private ?string $capacityMB = null;
    private ?string $colour = null;
    private ?string $availabilityText = null;
    private ?bool $isAvailable = null;
    private ?string $shippingText = null;
    private ?string $shippingDate = null;


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): void
    {
        $this->price = $price;
    }

    public function getImageUrl(): ?string
    {
        return $this->iamgeUrl;
    }

    public function setImageUrl(?string $imageUrl): void
    {
        $this->iamgeUrl = $imageUrl;
    }

    public function getCapacityMB(): ?string
    {
        return $this->capacityMB;
    }

    public function setCapacityMB(?string $capacityMB): void
    {
        $this->capacityMB = $capacityMB;
    }

    public function getColour(): ?string
    {
        return $this->colour;
    }

    public function setColour(?string $colour): void
    {
        $this->colour = $colour;
    }

    public function getAvailabilityText(): ?string
    {
        return $this->availabilityText;
    }

    public function setAvailabilityText(?string $availabilityText): void
    {
        $this->availabilityText = $availabilityText;
    }

    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(?bool $isAvailable): void
    {
        $this->isAvailable = $isAvailable;
    }

    public function getShippingText(): ?string
    {
        return $this->shippingText;
    }

    public function setShippingText(?string $shippingText): void
    {
        $this->shippingText = $shippingText;
    }

    public function getShippingDate(): ?string
    {
        return $this->shippingDate;
    }

    public function setShippingDate(?string $shippingDate): void
    {
        $this->shippingDate = $shippingDate;
    }
}
