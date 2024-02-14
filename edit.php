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
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])){
        if(!str_contains($_POST['email'], '@')){
            $_SESSION['error'] = "Email address must contain @";
            header("Location: edit.php?profile_id=".$_POST['profile_id']);
            return;
        }
        $stmt = $pdo->prepare("UPDATE profile SET first_name=:fn, last_name=:ln, email=:em, headline=:hl, summary=:sm WHERE profile_id=".$_POST['profile_id']);
        if($stmt->execute(array(
            ':fn' => $_POST['first_name'],
            ':ln' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':hl' => $_POST['headline'],
            ':sm' => $_POST['summary']
        ))){
            $_SESSION['success'] = "Profile updated successfully";
            header("Location: index.php");
            return;
        }else{
            $_SESSION['error'] = "Error while updating profile";
            header("Location: index.php");
            return;
        }
    }
}
$stmt = $pdo->query("SELECT * FROM profile WHERE user_id=".$_SESSION['user_id']." AND profile_id=".$_GET['profile_id']);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);
if($profile === false){
    $_SESSION['error'] = "Could not load profile";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mohamed Lahlami's Edit Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>Editing Profile for UMSI</h1>
    </header>
    <?php
    if(isset($_SESSION['error'])){
        echo '<p style="color: red;">'.$_SESSION['error'].'</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form method="post">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?=htmlentities($profile['first_name'])?>"><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?=htmlentities($profile['last_name'])?>"><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?=htmlentities($profile['email'])?>"><br>
        <label for="headline">Headline:</label>
        <input type="text" id="headline" name="headline" value="<?=htmlentities($profile['headline'])?>"><br>
        <label for="summary">Summary:</label><br>
        <textarea name="summary" id="summary" rows="4" cols="50"><?=htmlentities($profile['summary'])?></textarea><br>
        <input type="hidden" name="profile_id" value="<?=$profile['profile_id']?>">
        <input type="submit" name="submit" value="Save">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</body>
</html>