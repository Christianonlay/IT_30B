CREATE TABLE student(student_id int auto_increment primary key,
    student_first_name varchar(50) not null,
    student_last_name varchar(50) not null,
    student_course varchar(50) not null);

CREATE TABLE book(book_id int auto_increment primary key,
    book_name varchar(50) not null);

CREATE TABLE borrow(borrow_id int auto_increment primary key,
    student_id int,
    book_status varchar(50));

    alter table        
