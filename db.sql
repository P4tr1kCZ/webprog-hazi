create database webprogdb;
use webprogdb;
create table users (
		username varchar(255),
		password varchar(255),
		role varchar(255),
		primary key (username)
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

create table posts (
	id int auto_increment,
	title varchar(255),
	content varchar(255),
	author varchar(255) not null,
	created datetime not null,
	primary key (id),
	foreign key (author) references users(username)
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

create table comments (
	id int auto_increment,	 
	content varchar(255),
	author varchar(255) not null,
	created datetime not null,
	post int not null,

	primary key (id),
	foreign key (author) references users(username),
	foreign key (post) references posts(id) on delete cascade
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

create table menus (
	id int,
	name varchar(255),
	parentid int,
	controller varchar(255),
	action varchar(255),
	primary key (id)
) ENGINE=INNODB DEFAULT CHARACTER SET = utf8;

insert into users (username, password, role) VALUES ('admin', '$2y$10$gd6aRrNDHKI1tGkq/148LO7iB/rj139qp/LnRWLxebAmNniL3yazy', 'ADMIN');
INSERT INTO menus
  (id, name, parentid, controller, action)
VALUES
  (1, "Posts", NULL, "posts", "index"),
  (2, "Users", NULL, "users", "index"),    
  (3, "API", NULL, "api", "index"), 
  (4, "REST", 3, "api", "rest"),
  (5, "SOAP", 3, "api", "soap"),
  (6, "Logout", NULL, "users", "logout");