<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/News.php';
require_once __DIR__.'/../models/Comment.php';


class NewsRepository extends Repository{

    public function getNews(): array{
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM news ORDER BY news_id DESC;
        ');
        $stmt->execute();
        $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

         foreach ($news as $new) {
             $result[] = new News(
                 $new['title'],
                 $new['shortDescription'],
                 $new['description'],
                 $new['image'],
                 $new['news_id']
             );
         }

        return $result;
    }
    public function getSpecificNews(int $id):? News{

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM news
                WHERE news_id = :id;
        ');
        $stmt-> bindParam(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
        $news = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($news == false) {
            return null;
        }
        return new News(
            $news['title'],
            $news['shortDescription'],
            $news['description'],
            $news['image'],
            $news['news_id']
        );
    }


    public function addNews(News $news): void{
        $stmt = $this->database->connect()->prepare('
            INSERT INTO news (title, description, image, "shortDescription")
            VALUES (?, ?, ?, ?)
        ');

        $stmt->execute([
            $news->getTitle(),
            $news->getDescription(),
            $news->getImage(),
            $news->getShortDescription()
        ]);
    }

    public function addComment(Comment $comment, int $newsID, int $commAuthorID): void{

        $stmt = $this->database->connect()->prepare('
            INSERT INTO comments ("user_ID", "news_ID", text, date)
            VALUES (?, ?, ?, ?)
        ');
        $stmt->execute([
            $commAuthorID,
            $newsID,
            $comment->getText(),
            $comment->getDate()
        ]);
    }

    public function getComments(int $newsID):? Array{
        $result = [];

        $stmt = $this->database->connect()->prepare('
        select comments.text, comments.date, users.name from comments
            join users on comments."user_ID" = users.user_id
            where comments."news_ID" = :newsID ORDER BY comments.date DESC 
        ');
        $stmt-> bindParam(':newsID',$newsID, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($comments as $comm) {
            $result[] = new Comment(
                $comm['name'],
                $comm['text'],
                $comm['date']
            );
        }
        return $result;
    }
}