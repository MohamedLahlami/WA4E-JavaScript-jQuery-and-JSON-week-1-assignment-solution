<?php
include("pdo.php");
if (isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}
session_start();
$salt = "XyZzy12*_";
if (isset($_POST['submit'])){
    $check = hash('md5', $salt.$_POST['pass']);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
    $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
        $_SESSION['error'] = "Email or password incorrect";
        header("Location: login.php");
        return;
    }else{
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: index.php");
        return;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mohamed Lahlami's Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
    <header><h1>Please log in</h1></header>
    <?php
    if(isset($_SESSION['error'])){
        echo '<p style="color: red;">'.$_SESSION['error'].'</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form method="post">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email"><br>
        <label for="password">Password:</label>
        <input type="password" id="Password" name="pass"><br>
        <input type="submit" name="submit" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</body>
</html>