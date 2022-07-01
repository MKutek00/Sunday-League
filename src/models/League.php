<?php

class League{
    private $name;
    private $id;

    public function __construct(string $name, int $id){
        $this->name = $name;
        $this->id = $id;

    }

    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name): void{
        $this->name = $name;
    }

}