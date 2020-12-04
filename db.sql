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

insert into users (username, password, role) VALUES ('admin', '$2y$10$gd6aRrNDHKI1tGkq/148LO7iB/rj139qp/LnRWLxebAmNniL3yazy', 'ADMIN');