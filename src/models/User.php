<?php

class User {
    private $idUser;
    private $email;
    private $password;
    private $name;
    private $roleName;

    public function __construct(int $idUser, string $email, string $password, string $name, string $roleName) {
        $this->idUser = $idUser;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->roleName = $roleName;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    public function getRoleName(): string
    {
        return $this->roleName;
    }

    public function setRoleName(string $roleName): void
    {
        $this->roleName = $roleName;
    }

    public function getEmail(): string 
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}