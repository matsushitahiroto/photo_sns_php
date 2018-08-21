<?php

namespace MyApp\Model;

class Article extends \MyApp\Model {
  //新規記事登録処理
  public function post($values) {
    $stmt = $this->db->prepare("insert into articles (title, description, savePath, user_id, created, modified) values (:title, :description, :savePath, :user_id, now(), now())");
    $res = $stmt->execute([
      ':title' => $values['title'],
      ':description' => $values['description'],
      ':savePath' => $values['savePath'],
      ':user_id' => $values['user_id']
    ]);
    if($res === false) {
      throw new \MyApp\Exception\UploadError();
    }
  }

  public function getMyArticles($values) {
    // ログインユーザーの記事データ取得
    $stmt = $this->db->prepare("select * from articles where user_id = :user_id");
    $stmt->execute([
      ':user_id' => $values['user_id'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $article = $stmt->fetchAll();
    return $article;
  }

  public function findAllArticle() {
    $stmt = $this->db->query("select * from articles order by id");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

  public function getArticle($values) {
    // 記事データ取得
    $stmt = $this->db->prepare("select * from articles where id = :id");
    $stmt->execute([
      ':id' => $values['id'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }
}
