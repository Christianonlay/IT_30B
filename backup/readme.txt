1. CREATE DATABASE <database_name>;
2. SHOW DATABASE;
3. CONNECT <table_name>;
4. CREATE TABLE <table_name_in_plural>();
5. INSERT INTO <table_name_in_plural>
        (column) VALUES
        (values);

    # Utulity Command
    \! cls
    mysqldump -u root -p --databases library_db > C:\xampp\htdocs\IT30B\backup\08182026_library_db.sql

    mysqldump -u root -p --databases library_db > C:\xampp\htdocs\IT30B\backup\%date:~-4%_%date:~4,2%_%date:~7,2%_%time:~0,2%_%time:~3,2%_%time:~6,2%_library_db.sql

    SELECT  br.borrow_id, s.student_id,
        CONCAT(s.student_first_name, ' ', s.student_last_name) AS student_name, s.student_course,
        b.book_title, b.book_author, b.book_category,
        br.borrow_date
        FROM borrow br
        JOIN student s ON br.student_id = s.student_id
        JOIN books b ON br.book_id = b.book_id
        ORDER BY br.borrow_date DESC;
