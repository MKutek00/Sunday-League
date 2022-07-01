<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../models/Session.php';

class SecurityController extends AppController {

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }
    public function login(){

        if(!$this->isPost()){
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = md5(md5($_POST['password']));

        $user = $this->userRepository->getUser($email);
        if(!$user){
            return $this->render('login', ['messages' =>['Brak użytkownika w bazie danych']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['E-mail nie znaleziony w bazie danych!']]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Błędne hasło!']]);
        }

        $session = Session::getInstance();
        $session->id = $user -> getIdUser();
        $session->name = $user -> getName();
        $session->roleType = $user -> getRoleName();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/news");
    }


    public function register(){

        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmedPassword = $_POST['confirmedPassword'];
        $name = $_POST['name'];

        if ($password !== $confirmedPassword) {
            return $this->render('register', ['messages' => ['Please provide proper password']]);
        }
        $user = new User(0, $email,  md5(md5($password)), $name, 3);
        $this->userRepository->addUser($user);

        return $this->render('login', ['messages' => ['You\'ve been succesfully registrated!']]);

    }

    public function logout(){

        $session = Session::getInstance();
        $session->destroy();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
    }

    public function all_users(){
        $session = Session::getInstance();
        $roleType = $session -> roleType;
        if(!isset($_SESSION['id']) or $roleType != "Administrator"){
            header('Location: http://localhost:8080/news');
        }

        $users = $this->userRepository->getUsers();
        return $this->render('all_users', ['users' => $users]);
    }

    public function upgrade($id){
        $session = Session::getInstance();
        $roleType = $session -> roleType;
        if(!isset($_SESSION['id']) and $roleType != "Administrator"){
            header('Location: http://localhost:8080/news');
        }
        $this->userRepository->upgrade($id);
        http_response_code(200);
    }
    public function downgrade($id){
        $session = Session::getInstance();
        $roleType = $session -> roleType;
        if(!isset($_SESSION['id']) and $roleType != "Administrator"){
            header('Location: http://localhost:8080/news');
        }
        $this->userRepository->downgrade($id);
    }
    public function delete_user($id){
        $session = Session::getInstance();
        $roleType = $session -> roleType;
        if(!isset($_SESSION['id']) and $roleType != "Administrator"){
            header('Location: http://localhost:8080/news');
        }
        $this->userRepository->deleteUser($id);
    }

}