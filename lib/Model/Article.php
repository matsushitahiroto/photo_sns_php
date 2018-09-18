<?php

namespace MyApp\Model;

class Article extends \MyApp\Model {
  //新規記事登録処理
  public function post($values) {
    $stmt = $this->db->prepare("
    insert into articles (
      title, description, savePath, savePathSub1, savePathSub2, user_id, created, modified
    ) values (
      :title, :description, :savePath, :savePathSub1, :savePathSub2, :user_id, now(), now()
    )
    ");
    $res = $stmt->execute([
      ':title' => $values['title'],
      ':description' => $values['description'],
      ':savePath' => $values['savePath'],
      ':savePathSub1' => $values['savePathSub1'],
      ':savePathSub2' => $values['savePathSub2'],
      ':user_id' => $values['id']
    ]);
    if($res === false) {
      throw new \MyApp\Exception\UploadError();
    }
  }

  // ログインユーザーの記事データ取得
  public function getMyArticles($values) {
    $stmt = $this->db->prepare("
    select
      articles.id,
      articles.savePath,
      ifnull(like_count.like_count, 0) as lc,
      ifnull(comment_count.comment_count, 0) as cc
    from articles
    left join (
      select article_id, count(id) as like_count
      from likes
      group by article_id
    ) as like_count on articles.id = like_count.article_id
    left join (
      select article_id, count(id) as comment_count
      from comments
      group by article_id
    ) as comment_count on articles.id = comment_count.article_id
    where articles.user_id = :user_id
    order by articles.id desc
    ");
    $stmt->execute([
      ':user_id' => $values['user_id'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();

  }

// 全件記事データ取得
  public function findAllArticle() {
    $stmt = $this->db->query("
    select
      articles.id,
      articles.savePath,
      ifnull(like_count.like_count, 0) as lc,
      ifnull(comment_count.comment_count, 0) as cc
    from articles
    left join (
      select article_id, count(id) as like_count
      from likes
      group by article_id
    ) as like_count on articles.id = like_count.article_id
    left join (
      select article_id, count(id) as comment_count
      from comments
      group by article_id
    ) as comment_count on articles.id = comment_count.article_id
    order by articles.id desc
    ");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }
// 全件記事データ取得
  public function findAllLikeArticle() {
    $stmt = $this->db->query("
    select
      articles.id,
      articles.savePath,
      ifnull(like_count.like_count, 0) as lc,
      ifnull(comment_count.comment_count, 0) as cc
    from articles
    left join (
      select article_id, count(id) as like_count
      from likes
      group by article_id
    ) as like_count on articles.id = like_count.article_id
    left join (
      select article_id, count(id) as comment_count
      from comments
      group by article_id
    ) as comment_count on articles.id = comment_count.article_id
    order by lc desc, cc desc, articles.id desc
    ");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

  // 個別記事データ取得
  public function getArticle($values) {
    $stmt = $this->db->prepare("
    select
      articles.id,
      articles.user_id,
      articles.title,
      articles.description,
      articles.savePath,
      articles.savePathSub1,
      articles.savePathSub2,
      articles.created,
      articles.modified,
      users.name as name,
      ifnull(like_count.like_count, 0) as lc,
      ifnull(comment_count.comment_count, 0) as cc
    from articles
    left join users on articles.user_id = users.id
    left join (
      select article_id, count(id) as like_count
      from likes
      group by article_id
    ) as like_count on articles.id = like_count.article_id
    left join (
      select article_id, count(id) as comment_count
      from comments
      group by article_id
    ) as comment_count on articles.id = comment_count.article_id
    where articles.id = :id
    ");
    $stmt->execute([
      ':id' => $values['id'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }
}
