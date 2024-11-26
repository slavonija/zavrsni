drop database if exists videoteka;

create database if not exists videoteka 
character set utf8mb4 collate utf8mb4_general_ci;

use videoteka;


create table members(
	id int unsigned auto_increment,
    member_number char(10) unique not null,
    first_name varchar(50) not null,
    last_name varchar(50) not null,
    registration_date date not null,
    primary key(id)
);


create table rentals (
	id int unsigned auto_increment,
    rental_date date not null,
    return_date date,
    due_date date not null,
    late_fee decimal(10,2) default(0.00),
    price decimal(10,2) not null,
    member_ID int unsigned not null,
    movie_ID int unsigned not null,
    primary key (id)
);


create table movies (
	id int unsigned auto_increment,
    title varchar(100) not null,
    media_type varchar(50) not null,
    price_list_ID int unsigned not null,
    primary key (id)
);

create table price_lists (
	id int unsigned auto_increment,
    name varchar(50) not null,
	price decimal(10,2) not null,
    primary key (id)
);

create table genres (
	id int unsigned auto_increment,
    name varchar(50) not null,
    primary key (id)
);

create table movie_genres (
	id int unsigned auto_increment,
	genre_ID int unsigned not null,
    movie_ID int unsigned not null,
    primary key (id)
);

alter table rentals
add constraint fk_member_rental
foreign key (member_ID) references members(id),
add constraint fk_movie_rental
foreign key (movie_ID) references movies(id);

alter table movies
add constraint fk_movie_price_list
foreign key (price_list_ID) references price_lists(id);

alter table movie_genres
add constraint fk_movie_genre_genre
foreign key (genre_ID) references genres(id),
add constraint fk_movie_genre_movie
foreign key (movie_ID) references movies(id);

insert into members
(member_number, first_name, last_name, registration_date)
values
('2285566430', 'Ana', 'Anić', '2024-05-17');
insert into members
(member_number, first_name, last_name, registration_date)
values
('2285566431', 'Pero', 'Anić', '2024-05-17');



select * from members;

select @@sql_mode;