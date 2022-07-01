<?php

class News {
    private $image;
    private $title;
    private $description;
    private $shortDescription;
    private $id;

    public function __construct($title, $shortDescription, $description, $image, $id){
        $this->title = $title;
        $this->shortDescription = $shortDescription;
        $this->description = $description;
        $this->image = $image;
        $this->id = $id;
    }

    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    public function setShortDescription($shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }
}