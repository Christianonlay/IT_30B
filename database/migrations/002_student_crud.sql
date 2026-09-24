--student SQL 1 : SELECT ALL * student


SELECT *FROM student;
--student SQL#2 ; select students in asc order by id; 

SELECT * FROM student
    ORDER BY student_id ASC

--student SQL#3 ; select students in asc order by id; 
SELECT * FROM student
    ORDER BY student_id DESC;

--student SQL#4 ; select students in asc order by last_name; 
    SELECT * FROM student
    ORDER BY student_last_name ASC;
--student SQL#5 ; select students in asc order by last_name; 
    SELECT * FROM student
    ORDER BY student_last_name DESC;
--student SQL#6 ; select students in asc order by first_name; 
    SELECT * FROM student
    ORDER BY student_first_name ASC;
--student SQL#7 ; select students in asc order by first_name; 
    SELECT * FROM student
    ORDER BY student_first_name DESC;

    -- you can modify displayed columns by selecting
    --specific columns after SELECT comand

    SELECT student_first_name,
             student_last_name
             FROM student
             ORDER BY student_first_name ASC;

--student SQL#9 LIMIT 1 YOU CAN CHANGE THE LIMIT TO ANY NUMBER
     SELECT student_first_name,
             student_last_name
             FROM student
             ORDER BY student_first_name ASC
             LIMIT 2;
--student SQL#10 - select a student based on id
              SELECT student_first_name,
             student_last_name
             FROM student
            WHERE student_id = 1
             LIMIT 2;
--student SQL#11 - update studetn name a student basedon id
UPDATE student
SET student_first_name='CHRISTIAN JAY',
    student_last_name='ONLAY'
    WHERE student_id = 1;

 -- student