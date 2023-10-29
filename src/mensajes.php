<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: index.php");
    exit();
}
try{
    $db = new PDO('mysql:host=127.0.0.1;port=33060;dbname=oremessenger', 'root', 'ejemplo_pass');

    $sqlSelect = "SELECT id, body FROM message WHERE username=:username";
    $stmtSelect = $db->prepare($sqlSelect);
    $stmtSelect->execute([':username' => $username]);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $id_message = $_POST['id_message'];

        $sqlDelete = "DELETE FROM message WHERE id =:idmessage";
        $stmtDelete = $db->prepare($sqlDelete);
        $stmtDelete->execute([':idmessage' => $id_message]);

        header("Location: {$_SERVER['PHP_SELF']}"); //REDIRIGE AL ARCHIVO EN USO PARA ACTUALIZAR LA PÁGINA,
        // LO USO PARA NO PULSAR DOS VECES EL BOTON DELETE PARA BORRAR UN MENSAJE
        exit();
    }

}catch (PDOException $e){
    $error = 'Database error: ' . $e->getMessage();
}



?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>List of messages</title>
    <link rel="stylesheet" href="oremessenger.css">

</head>
<body>

<h1>Oretania Messenger</h1>
<h2>Messages of <?php echo $username; ?>. </h2>
<?php
    while ($message = $stmtSelect->fetch(PDO::FETCH_ASSOC)){
        echo "<p> Message: $message[body]</p>";
        echo "<form method='post'>
              <input type='hidden' name='id_message' value='" . $message['id'] . "'>
              <button type='submit' name='delete'>Delete message</button>
          </form>";
    }
?>
</body>
<br />
<form action="nuevo.php" method="get"> <button class="new-message">New message</button> </form>

<form action="index.php" method="get"> <button class="log-out">Log out</button> </form>

</html>