create database photo_sns_php;

grant all on photo_sns_php. * to dbuser@localhost identified by 'xj54bivpjn7hr';

use photo_sns_php

create table users (
  id int not null auto_increment primary key,
  name varchar(255) unique,
  description varchar(255),
  email varchar(255) unique,
  password varchar(255),
  created datetime,
  modified datetime
);

desc users;

create table articles (
  id int not null auto_increment primary key,
  user_id int not null,
  title varchar(255),
  description varchar(255),
  savePath varchar(255) unique,
  created datetime,
  modified datetime
);

desc articles;

create table comments (
  id int not null auto_increment primary key,
  article_id int not null,
  user_id int not null,
  comment varchar(255),
  created datetime,
  modified datetime
);

create table goods (
  id int not null auto_increment primary key,
  article_id int not null,
  user_id int not null,
  created datetime,
  modified datetime
);
