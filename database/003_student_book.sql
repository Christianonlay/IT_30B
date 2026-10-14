
SELECT book_title,
    book_author
    FROM books
      ORDER BY book_title ASC;

 UPDATE books
SET book_title='the spotibai',
    book_author='khyle'
    WHERE book_id = 1;

    SELECT student_first_name,
    student_last_name
    FROM student
      ORDER BY student_first_name ASC;

       SELECT student_first_name,
             student_last_name
             FROM student
            WHERE student_id = 1
             LIMIT 2;