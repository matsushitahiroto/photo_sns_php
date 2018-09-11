<?php

namespace MyApp\Model;

class Comment extends \MyApp\Model {
  //新規登録処理


  // コメント取得
  public function getComment($values) {
    $stmt = $this->db->prepare("
    select
      comments.id,
      comments.article_id,
      comments.user_id,
      comments.comment,
      comments.created,
      users.name as name
    from comments
    join users on comments.user_id = users.id
    where comments.article_id = :article_id;
    ");
    $stmt->execute([
      ':article_id' => $values['article_id']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

  public function upload($values) {
    $stmt = $this->db->prepare("
    insert into comments (
      article_id, user_id, comment, created, modified
    ) values (
      :article_id, :user_id, :comment, now(), now()
    )
    ");
    $stmt->execute([
      ':article_id' => $values['article_id'],
      ':user_id' => $values['user_id'],
      ':comment' => $values['comment']
    ]);
    return $this->db->lastInsertId();
  }

  public function delete($values) {
    $stmt = $this->db->prepare("
    delete
    from comments
    where id = :id
    ");
    $stmt->execute([
      ':id' => $values['id']
    ]);
    return[];
  }

  public function count($values) {
    $stmt = $this->db->prepare("
    select count(id)
    from comments
    where article_id = :article_id
    ");
    $stmt->execute([
      ':article_id' => $values['article_id']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchColumn();
  }
}
