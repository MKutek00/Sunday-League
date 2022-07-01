<?php

class Comment{
    private $userName;
    private $text;
    private $date;


    public function __construct($userName, $text, $date)
    {
        $this->userName = $userName;
        $this->text = $text;
        $this->date = $date;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text): void
    {
        $this->text = $text;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }


}