<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 10/10/18
 * Time: 10:10
 */

namespace Model;

class Announce
{
    private $id;

    private $title;

    private $content;

    private $price;

    private $capacity;

    private $city;

    private $img;

    private $good;

    private $activity;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Item
     */
    public function setId($id): Announce
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return Item
     */
    public function setTitle($title): Announce
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent($content): Announce
    {
        $this->content = $content;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice($price): Announce
    {
        $this->price = $price;

        return $this;
    }

    public function getCapacity(): Int
    {
        return $this->capacity;
    }

    public function setCapacity($capacity): Announce
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity($city): Announce
    {
        $this->city = $city;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg($img): Announce
    {
        $this->img = $img;

        return $this;
    }

    public function getGood(): string
    {
        return $this->good;
    }

    public function setGood($good): Announce
    {
        $this->good = $good;

        return $this;
    }

    public function getActivity(): string
    {
        return $this->activity;
    }

    public function setActivity($activity): Announce
    {
        $this->activity = $activity;

        return $this;
    }
}
