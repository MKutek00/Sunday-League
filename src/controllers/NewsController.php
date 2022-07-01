<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/News.php';
require_once __DIR__ .'/../repository/NewsRepository.php';
require_once __DIR__ .'/../repository/UserRepository.php';


class NewsController extends AppController {

    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/img/uploads/';

    private $message = [];
    private $newsRepository;
    private $userRepository;

    public function __construct(){
        parent::__construct();
        $this->newsRepository = new NewsRepository();
        $this->userRepository = new UserRepository();

    }

    public function news(){

        $news = $this->newsRepository->getNews();
        $this->render('news', ['news' => $news]);
    }

    public function add_news(){
        $session = Session::getInstance();
        $roleType = $session -> roleType;
        if(!isset($_SESSION['id']) or $roleType === "Klient"){
            header('Location: http://localhost:8080/news');
        }
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            if(move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            ) == false){
                die("zly move");
            }

            // TODO create new project object and save it in database
            $news = new News($_POST['title'],$_POST['shortDescription'], $_POST['description'], $_FILES['file']['name'], 0);
            $this->newsRepository->addNews($news);

            return $this->render('news',[
                'messages' => $this->message,
                'news' => $this->newsRepository->getNews()]
                );
        }
        return $this->render('add_news', ['messages' => $this->message]);
    }

    private function validate(array $file): bool{
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'Za duży rozmiar pliku!';
            echo "Rozmiar";
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'Zły format pliku';
            return false;
        }
        return true;
    }

    public function add_comm(){
        $idArticle = $_GET["id"];

        $session = Session::getInstance();
        $comm_author = $session -> name;
        if(!isset($_SESSION['id'])){
            header('Location: http://localhost:8080/Article?id='.$idArticle);
        }

        $comm_text = $_POST['add_commText'];
        $commAuthorID = $session -> id;
        $newComm = new Comment($comm_author, $comm_text, date('Y-m-d H:i:s'));
        $this->newsRepository->addComment($newComm, $idArticle, $commAuthorID);

        header('Location: http://localhost:8080/Article?id='.$idArticle);
    }

    public function Article(){

        $id = $_GET["id"];
        $articles = $this->newsRepository->getSpecificNews($id);
        $comments = $this->newsRepository->getComments($id);
        return $this->render('Article', ['article' => $articles, 'comments' =>$comments]);

    }
}
