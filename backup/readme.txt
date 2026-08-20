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

    mysqldump -u root -p --databases library_db > C:\xampp\htdocs\IT30B\backup\%date:~-4%%date:~4,2%%date:~7,2%_%time:~0,2%%time:~3,2%%time:~6,2%_library_db.sql