<?php

namespace MyApp\Model;

class User extends \MyApp\Model {
  //新規ユーザー登録処理
  public function create($values) {
    $stmt = $this->db->prepare("insert into users (name, description, email, password, created, modified) values (:name, :description, :email, :password, now(), now())");
    $res = $stmt->execute([
      ':name' => $values['name'],
      ':description' => $values['description'],
      ':email' => $values['email'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);
    if($res === false) {
      throw new \MyApp\Exception\DuplicateEmail();
    }
  }

  //プロフィール内容の変更
  public function custom($values) {
    //idでログインしてパスワードを比較
    $stmt = $this->db->prepare("select * from users where id = :id");
    $stmt->execute([
      ':id' => $values['id'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    // もしパスワードがちがければエラー表示
    if(!password_verify($values['password'], $user->password)) {
      throw new \MyApp\Exception\UnmatchPassword();
    }
    // 内容の書き換え
    $stmt = $this->db->prepare("update users set name = :name, description = :description, email = :email, modified = now() where id = :id");
    $res = $stmt->execute([
      ':name' => $values['name'],
      ':description' => $values['description'],
      ':email' => $values['email'],
      ':id' => $values['id']
    ]);
    if($res === false) {
      throw new \MyApp\Exception\DuplicateEmail();
    }
    // 再度ログイン
    $stmt = $this->db->prepare("select * from users where email = :email");
    $stmt->execute([
      ':email' => $values['email'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    return $user;

  }

// ログイン処理
  public function login($values) {
    $stmt = $this->db->prepare("select * from users where email = :email");
    $stmt->execute([
      ':email' => $values['email'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    if(empty($user)) {
      throw new \MyApp\Exception\UnmatchUsernameOrPassword();
    }
    if($values['name'] !== $user->name) {
      throw new \MyApp\Exception\UnmatchUsernameOrPassword();
    }
    if(!password_verify($values['password'], $user->password)) {
      throw new \MyApp\Exception\UnmatchUsernameOrPassword();
    }

    return $user;
  }

// ユーザー情報の取得
  public function findAllUser() {
    $stmt = $this->db->query("select * from users order by id");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

  public function getPostUser($values) {
    // 記事データ取得
    $stmt = $this->db->prepare("select * from users where id = :id");
    $stmt->execute([
      ':id' => $values['uid'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }
}
