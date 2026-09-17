<?php


$host = 'localhost';
$db = 'IT30_LAB_DB';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host; dbname=$db; charset=$charset";

$option = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,

];

try{
    $pdo = new PDO($dsn,$user,$pass, $option);
    echo 'connection successful';
}catch(PDOException $e){
    die("Database connection failed " . $e->getMessage());

}
session_start();
    $section = $_GET['section'] ??'student';

    $action = $_GET['action'] ?? '';

    if($section==='student'){
        $stmt = $pdo->("
        SELECT *
        FROM student
        ORDER BY student_id DESC
        ");
        $student = $stmt->fetchALL();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>library System</title>
</head>
<body>
    <h1>Simple library System</h1>
    <nav>
        <a href="index.php?section=student">student</a>
         <a href="index.php?section=book">books</a>
          <a href="index.php?section=borrow">borrow</a>
</nav>
<hr>
<?php if ($section === 'student'): ?>
    <h1>student</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>last Name</th>
                <th>Course</th>
                <th>Created at</th>
                <th>Actions</th>

            </tr>
            <thead>
                <tbody>
                    <?php foreach($student as $student): ?>
                        <tr>
                            <td>
                                <?htmlspecialchars($student['student_id']) ?>
                                <tr>
                                    <td>
                                         <?htmlspecialchars($student['student_first_name']) ?>
                                <tr>
                                    <td> <?htmlspecialchars($student['student_last_name']) ?>
                                <tr>
                                    <td> <?htmlspecialchars($student['student_course']) ?>
                                <tr>
                                    <td> <?htmlspecialchars($student['student_created_at']) ?>
                                <tr>
                                    <td>
                                        <a>Edit</a>
                                        <a>Delete</a>
                    </td>
                     </tr>
                     <?php endforeach?>   
                </tbody>
            </thead>

                    </table>

    <?php endif;?>

    <?php if ($section === 'books'): ?>
    <h1>books</h1>
    <?php endif;?>

    <?php if ($section === 'borrow'): ?>
    <h1>borrow</h1>
    <?php endif;?>
    
    
</body>
</html>