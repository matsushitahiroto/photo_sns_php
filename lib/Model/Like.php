<?php

namespace MyApp\Model;

class Like extends \MyApp\Model {
  // 個別記事データ取得
  public function getLike($values) {
    $stmt = $this->db->prepare("
    select
      likes.id,
      likes.user_id,
      likes.created,
      users.iconPath,
      users.name
    from likes
    left join users
    on likes.user_id = users.id
    where likes.article_id = :article_id
    ");
    $stmt->execute([
      ':article_id' => $values['article_id'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

  public function check($values) {
    $stmt = $this->db->prepare("
    select exists (
      select id
      from likes
      where article_id = :article_id and user_id = :user_id
    ) as bool
    ");
    $stmt->execute([
      ':article_id' => $values['article_id'],
      ':user_id' => $values['user_id']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

  public function upload($values) {

    $stmt = $this->db->prepare("
    insert into likes (user_id, article_id, created, modified)
      select :user_id, :article_id, now(), now()
      from articles
      where exists (
        select id
        from articles
        where id = :article_id)
      and not exists (
        select id
        from likes
        where user_id = :user_id
        and article_id = :article_id)
      limit 1
    ");
    $stmt->execute([
      ':article_id' => $values['article_id'],
      ':user_id' => $values['user_id']
    ]);
    return $this->db->lastInsertId();
  }

  public function delete($values) {
    $stmt = $this->db->prepare("
    delete
    from likes
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
    from likes
    where article_id = :article_id
    ");
    $stmt->execute([
      ':article_id' => $values['article_id']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchColumn();
  }

  public function findAll() {
    $stmt = $this->db->query("
    select *
    from likes
    order by id
    ");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }
}
