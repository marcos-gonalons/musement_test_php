<?php

namespace App\Service\Api\Musement\CitiesAPI\Entities;

class City
{

    private ?int $id = null;
    private ?string $name = null;
    private ?string $code = null;
    private ?string $content = null;
    private ?string $description = null;
    private ?string $title = null;
    private ?string $headline = null;
    private ?string $more = null;
    private ?int $weight = null;
    private ?float $latitude = null;
    private ?float $longitude = null;
    private ?Country $country = null;
    private ?string $coverImageUrl = null;
    private ?string $url = null;
    private ?int $activitiesCount = null;
    private ?string $timezone = null;
    private ?int $venueCount = null;
    private ?bool $showInPopular = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): City
    {
        $this->id = $id;
        return $this;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): City
    {
        $this->name = $name;
        return $this;
    }


    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): City
    {
        $this->code = $code;
        return $this;
    }


    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): City
    {
        $this->content = $content;
        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): City
    {
        $this->description = $description;
        return $this;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): City
    {
        $this->title = $title;
        return $this;
    }


    public function getHeadline(): ?string
    {
        return $this->headline;
    }

    public function setHeadline(string $headline): City
    {
        $this->headline = $headline;
        return $this;
    }


    public function getMore(): ?string
    {
        return $this->more;
    }

    public function setMore(string $more): City
    {
        $this->more = $more;
        return $this;
    }


    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): City
    {
        $this->weight = $weight;
        return $this;
    }


    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): City
    {
        $this->latitude = $latitude;
        return $this;
    }


    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): City
    {
        $this->longitude = $longitude;
        return $this;
    }


    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): City
    {
        $this->country = $country;
        return $this;
    }


    public function getCoverImageUrl(): ?string
    {
        return $this->coverImageUrl;
    }

    public function setCoverImageUrl(string $coverImageUrl): City
    {
        $this->coverImageUrl = $coverImageUrl;
        return $this;
    }


    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): City
    {
        $this->url = $url;
        return $this;
    }

    public function getActivitiesCount(): ?int
    {
        return $this->activitiesCount;
    }

    public function setActivitiesCount(int $activitiesCount): City
    {
        $this->activitiesCount = $activitiesCount;
        return $this;
    }


    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): City
    {
        $this->timezone = $timezone;
        return $this;
    }


    public function getVenueCount(): ?int
    {
        return $this->venueCount;
    }

    public function setVenueCount(int $venueCount): City
    {
        $this->venueCount = $venueCount;
        return $this;
    }


    public function getShowInPopular(): ?bool
    {
        return $this->showInPopular;
    }

    public function setShowInPopular(bool $showInPopular): City
    {
        $this->showInPopular = $showInPopular;
        return $this;
    }
}
