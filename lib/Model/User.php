<?php

namespace MyApp\Model;

class User extends \MyApp\Model {
  //新規ユーザー登録処理
  public function create($values) {
    $stmt = $this->db->prepare("
    insert into users (
      name, description, email, password, user_created, user_modified
    ) values (
      :name, :description, :email, :password, now(), now()
    )
    ");
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
  public function checkPassword($values) {
    //idでログインしてパスワードを比較
    $stmt = $this->db->prepare("
    select *
    from users
    where id = :id
    ");
    $stmt->execute([
      ':id' => $values['id']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    // もしパスワードがちがければエラー表示
    if(!password_verify($values['password'], $user->password)) {
      throw new \MyApp\Exception\UnmatchPassword();
    }
  }

  public function custom($values) {
    // 内容の書き換え
    $stmt = $this->db->prepare("
    update users set
      name = :name,
      description = :description,
      email = :email,
      modified = now()
      where id = :id
    ");
    $res = $stmt->execute([
      ':name' => $values['name'],
      ':description' => $values['description'],
      ':email' => $values['email'],
      ':id' => $values['id']
    ]);
    if($res === false) {
      throw new \MyApp\Exception\DuplicateEmail();
    }
  }

  public function reload($values) {
    // 再度ログイン
    $stmt = $this->db->prepare("
    select
      users.id,
      users.name,
      users.description,
      users.password,
      users.email,
      users.created,
      users.modified,
      count(articles.id) as ac
    from users
    left join articles on users.id = articles.user_id
    where users.id = :id
    order by users.id
    ");
    $stmt->execute([
      ':id' => $values['id'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    if(empty($user)) {
      throw new \MyApp\Exception\DownloadError();
    }
    return $user;

  }

// ログイン処理
  public function login($values) {
    $stmt = $this->db->prepare("
    select
      users.id,
      users.name,
      users.description,
      users.password,
      users.email,
      users.created,
      users.modified,
      count(articles.id) as ac
    from users
    left join articles on users.id = articles.user_id
    where users.email = :email
    order by users.id
    ");
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

  public function adminLogin($values) {
    $stmt = $this->db->prepare("
    select *
    from users
    where id = :id
    ");
    $stmt->execute([
      ':id' => $values['id'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    if(empty($user)) {
      throw new \MyApp\Exception\UnmatchUsernameOrPassword();
    }
    if($user->admin !== '1') {
      throw new \MyApp\Exception\NoAdminUser();
    }
    if($values['id'] !== $user->id) {
      throw new \MyApp\Exception\UnmatchUsernameOrPassword();
    }
    if(!password_verify($values['password'], $user->password)) {
      throw new \MyApp\Exception\UnmatchUsernameOrPassword();
    }

    return $user;
  }

  public function adminGetUser($values) {
    $stmt = $this->db->prepare("
    select *
    from users
    where id = :id
    ");
    $stmt->execute([
      ':id' => $values['id'],
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetch();
  }

  public function adminCustom($values) {
    // 内容の書き換え
    $stmt = $this->db->prepare("
    update users set
      admin = :admin,
      name = :name,
      description = :description,
      email = :email,
      modified = now()
      where id = :id
    ");
    $res = $stmt->execute([
      ':name' => $values['name'],
      ':admin' => $values['admin'],
      ':description' => $values['description'],
      ':email' => $values['email'],
      ':id' => $values['id']
    ]);
    if($res === false) {
      throw new \MyApp\Exception\DuplicateEmail();
    }
  }

  public function delete($values) {
    $stmt = $this->db->prepare("
    delete
    from users
    where id = :id
    ");
    $res = $stmt->execute([
      ':id' => $values['id']
    ]);
    if($res === false) {
      throw new \MyApp\Exception\DeleteError();
    }
  }

  public function findAll() {
    $stmt = $this->db->query("
    select *
    from users
    order by id
    ");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }

}
