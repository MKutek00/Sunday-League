<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository{

    public function getUsers():array {
        $stmt = $this->database->connect()->prepare('
            select user_id, email, password, users.name, roles.name from users
                join roles on users.role_type = roles."role_ID" ORDER BY user_id
        ');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_NAMED);
        foreach ($users as $user){
            $result[] = new User(
                $user['user_id'],
                $user['email'],
                $user['password'],
                $user['name'][0],
                $user['name'][1]
            );
        }
        return $result;
    }

    public function getUser(string $email): ?User{
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users
                  JOIN roles on  users.role_type = roles."role_ID" WHERE email =:email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_NAMED);

        if ($user == false) {
            return null;
        }
        return new User(
            $user['user_id'],
            $user['email'],
            $user['password'],
            $user['name'][0],
            $user['name'][1]
        );
    }
    public function getUserWithID(int $id):? User{
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE user_id =:id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return new User(
            $user['user_id'],
            $user['email'],
            $user['password'],
            $user['name'],
            'notGiven'
        );
    }

    public function addUser(User $user){
        $stmt = $this->database->connect()->prepare('
        INSERT INTO users (name, email, password, role_type)
        VALUES (?, ?, ?, ?)
        ');
        $stmt->execute([
            $user->getName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getRoleName()
        ]);
    }

    public function upgrade(int $id){
        $stmt = $this->database->connect()->prepare('
        UPDATE users SET role_type = role_type - 1 WHERE user_id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function downgrade(int $id){
        $stmt = $this->database->connect()->prepare('
        UPDATE users SET role_type = role_type + 1 WHERE user_id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function deleteUser(int $id){
        $stmt = $this->database->connect()->prepare('
        DELETE FROM users WHERE user_id = :id 
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}