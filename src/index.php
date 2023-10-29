<?php

var_dump($_POST);
$error = '';

if (isset($_POST['login'])){
    try {
        $db = new PDO('mysql:host=127.0.0.1;port=33060;dbname=oremessenger', 'root', 'ejemplo_pass');

        $username = $_POST['username'];
        $query = $db->query("SELECT * FROM person WHERE username = '$username'");
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user){
            if ($user['password'] === $_POST['password']){
                header("Location: mensajes.php");
            }else{
                $error = 'Incorrect password';
            }
        }
    }catch (PDOException $e){
        $error = 'Database error: ' . $e->getMessage();
    }
}

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de mensajes</title>
</head>
<body>
<h1>Oretania Messenger</h1>
<h2>Log In</h2>
<?php
echo "<h3> $error </h3>";
?>

<form method="post">
    <label>Username: </label>
    <input type="text" name="username" placeholder="Enter your username"/> <br /><br />
    <label>Password: </label>
    <input type="password" name="password" placeholder="Enter your password"/> <br /><br />
    <button type="submit" name="login" value="ok">Log in</button>
</form>
</body>
</html>