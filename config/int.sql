create database photo_sns_php;

grant all on photo_sns_php. * to dbuser@localhost identified by 'xj54bivpjn7hr';

use photo_sns_php

create table users (
  id int not null auto_increment primary key,
  admin tinyint not null default 0,
  name varchar(255) unique,
  description varchar(255),
  email varchar(255) unique,
  password varchar(255),
  created datetime,
  modified datetime
);

create table articles (
  id int not null auto_increment primary key,
  user_id int not null,
  title varchar(255),
  description varchar(255),
  savePath varchar(255) unique,
  savePathSub1 varchar(255) unique,
  savePathSub2 varchar(255) unique,
  created datetime,
  modified datetime
);

create table comments (
  id int not null auto_increment primary key,
  article_id int not null,
  user_id int not null,
  comment varchar(255),
  created datetime,
  modified datetime
);

create table likes (
  id int not null auto_increment primary key,
  article_id int not null,
  user_id int not null,
  created datetime,
  modified datetime
);

-- 以下テスト用
-- 一覧表示用
select
articles.id,
articles.savePath,
ifnull(like_count.like_count, 0) as lc,
ifnull(comment_count.comment_count, 0) as cc
from articles
left join (
  select article_id, count(id) as like_count
  from likes group by article_id
) as like_count on articles.id = like_count.article_id
left join (
  select article_id, count(id) as comment_count
  from comments group by article_id
) as comment_count on articles.id = comment_count.article_id
order by articles.id desc;

-- 人気一覧表示用
select
articles.id,
articles.savePath,
ifnull(like_count.like_count, 0) as lc,
ifnull(comment_count.comment_count, 0) as cc
from articles
left join (
  select article_id, count(id) as like_count
  from likes group by article_id
) as like_count on articles.id = like_count.article_id
left join (
  select article_id, count(id) as comment_count
  from comments group by article_id
) as comment_count on articles.id = comment_count.article_id
order by lc desc, cc desc, articles.id desc;

-- alter table users change user_id id;

-- 個別記事データ取得
select
articles.id,
articles.user_id,
articles.title,
articles.description,
articles.savePath,
articles.created,
articles.modified,
users.name as name,
ifnull(like_count.like_count, 0) as lc,
ifnull(comment_count.comment_count, 0) as cc
from articles
left join users on articles.user_id = users.id
left join (
  select article_id, count(id) as like_count
  from likes group by article_id
) as like_count on articles.id = like_count.article_id
left join (
  select article_id, count(id) as comment_count
  from comments group by article_id
) as comment_count on articles.id = comment_count.article_id
where articles.id = 1;

-- ユーザーデータ取得
select
users.id,
users.name,
users.description,
users.password,
users.email,
users.created,
users.modified,
count(articles.id) as articles
from users
left join articles
on users.id = articles.user_id
where users.id = 1
order by users.id;

-- 投稿記事一覧
select
articles.id,
articles.savePath,
ifnull(like_count.like_count, 0) as lc,
ifnull(comment_count.comment_count, 0) as cc
from articles
left join (
  select article_id, count(id) as like_count
  from likes group by article_id
) as like_count on articles.id = like_count.article_id
left join (
  select article_id, count(id) as comment_count
  from comments group by article_id
) as comment_count on articles.id = comment_count.article_id
where articles.user_id = 1
order by articles.id desc;

select
count(comments.id)
from comments
where article_id = 1;

select
comments.id,
comments.article_id,
comments.user_id,
comments.comment,
comments.created,
users.name as name
from comments
join users on comments.user_id = users.id
where comments.article_id = 13;

select
*
from comments
join users on comments.user_id = users.id
where comments.article_id = 13;

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
    and article = :article_id)
  limit 1;

select * from likes where exists (select id from likes where article_id = 1 and user_id = 1);
