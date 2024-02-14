<?php
include("pdo.php");
session_start();
if (!isset($_SESSION['user_id'])){
    die("Not logged in");
    return;
}
if (isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}
if (isset($_POST['submit'])){
    if(!isset($_POST['first_name']) || !isset($_POST['last_name']) || !isset($_POST['email']) || !isset($_POST['headline']) || !isset($_POST['summary'])){
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php?profile_id=".$_POST['profile_id']);
        return;
    }
    if(!str_contains($_POST['email'], '@')){
        $_SESSION['error'] = "Email address must contain @";
        header("Location: add.php?profile_id=".$_POST['profile_id']);
        return;
    }
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['headline'] = $_POST['headline'];
    $_SESSION['summary'] = $_POST['summary'];
    header("Location: add.php");
    return;
}
if(isset($_SESSION['first_name']) && isset($_SESSION['last_name']) && isset($_SESSION['email']) && isset($_SESSION['headline']) && isset($_SESSION['summary'])){
    $stmt = $pdo->prepare('INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) VALUES ( :uid, :fn, :ln, :em, :he, :su)');
    $dataArray = array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_SESSION['first_name'],
        ':ln' => $_SESSION['last_name'],
        ':em' => $_SESSION['email'],
        ':he' => $_SESSION['headline'],
        ':su' => $_SESSION['summary']
    );
    if($stmt->execute($dataArray)){
        unset($_SESSION['first_name']);
        unset($_SESSION['last_name']);
        unset($_SESSION['email']);
        unset($_SESSION['headline']);
        unset($_SESSION['summary']);
        $_SESSION['success'] = "Profile Added Successfully";
    }else{
        $_SESSION['error'] = "An error occurred while adding profile";
    }
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mohamed Lahlami's Add Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <header>
        <h1>Adding Profile for UMSI</h1>
    </header>
    <?php
    if(isset($_SESSION['error'])){
        echo '<p style="color: red;">'.$_SESSION['error'].'</p>';
        unset($_SESSION['error']);
    }
    if(isset($_SESSION['success'])){
        echo '<p style="color: green;">'.$_SESSION['success'].'</p>';
        unset($_SESSION['success']);
    }
    ?>
    <form method="post">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name"><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name"><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email"><br>
        <label for="headline">Headline:</label>
        <input type="text" id="headline" name="headline"><br>
        <label for="summary">Summary:</label><br>
        <textarea name="summary" id="summary" rows="4" cols="50"></textarea><br>
        <input type="submit" onclick="return doValidate();" name="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</body>

</html>