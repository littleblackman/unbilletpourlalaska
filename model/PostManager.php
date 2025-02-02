<?php
namespace www\model;
require_once("model/Post.php");
require_once("model/Manager.php");
require_once("model/Author.php");
/**
 * Class PostManager who is in charge of all the features for a post in the website
 * @package www\model
 */
class PostManager extends Manager
{
    /**
     * @return array
     */
    public function getPosts($page)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT p.id,p.title,p.content,p.post_date,m.firstname,m.lastname FROM post AS p LEFT JOIN member AS m ON p.member_id=m.id ORDER BY post_date DESC LIMIT :page,3');
        $req-> bindValue(':page', (int)$page, \PDO::PARAM_INT);
        $req->execute();
       // $req->debugDumpParams();
       // $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Post::class);
        //$posts = $req->fetchAll();
        $posts = array();//tableau dobjets post
        while($post = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $author= new Author();
            $author->setFirstname($post['firstname']);
            $author->setLastname($post['lastname']);
            $article= new Post();
            $article->setId($post['id']);
            $article->setTitle($post['title']);
            $article->setContent($post['content']);
            $article->setCreationDate($post['post_date']);
            $article->setAuthor($author);
        if ($article)
            array_push($posts,$article);
                // ajout  setter article posts tableau cree l17
        }
        return $posts;
    }
    public function getPost($articleId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM post WHERE id = ?');
        $req->execute(array($articleId));
        $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Post::class);
        $post = $req->fetch();
        return $post;
    }
    /**
    * method modify post 
    * @param Post $post
    */
    public function modifyPost($post)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE post SET content = ?,title = ?  WHERE id = ?');
        $reaffectedLines =$req->execute(array($post->getContent(),$post->getTitle(),$post->getId()));
       return $reaffectedLines;
    }
    public function deletePost($articleId)
    {
      $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM post  WHERE id = ?'); 
        $deleteLines= $req->execute(array($articleId));
        return $deleteLines;
    }
    public function addPost($post)
    { try{
      $db = $this->dbConnect();
        $posts = $db->prepare('INSERT INTO post(title, content,post_date,member_id) VALUES(?,? , NOW(),?)');
        var_dump($_SESSION) ;
        var_dump($post) ;
        $newLines = $posts->execute(array($post->getTitle(),$post->getContent(),$_SESSION['id']));
        return $newLines;
    }catch(\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
   }
   public function  nbPosts()
   {
       try {
           $db = $this->dbConnect();
           $req = $db->prepare('SELECT COUNT(*) FROM post');
           $req->execute();
           return $req->fetch();
       }catch(\PDOException $e) {
           echo "Error: " . $e->getMessage();
       }
   }
}
?>
