<?php
session_start();

if (isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}else{
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $body = $_POST['add'];
    try{
        $db = new PDO('mysql:host=127.0.0.1;port=33060;dbname=oremessenger', 'root', 'ejemplo_pass');

        $sqlInsert = "INSERT INTO message (username, body) VALUES (:username , :body)";
        $stmtSelect = $db->prepare($sqlInsert);
        $stmtSelect->execute([':username' => $username, ':body' => $body]);
        header("Location: mensajes.php");
    }catch (PDOException $e){
        $error = 'Database error: ' . $e->getMessage();
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New message</title>
    <link rel="stylesheet" href="oremessenger.css">
</head>
<body>
    <h1>Add a new message</h1>
    <form method="post">
        <label><textarea name="add" placeholder="Enter a new message" ></textarea></label>
        <label> <input type="submit" name="submit-message" value="Submit message"> </label>
    </form>
</body>
</html>
