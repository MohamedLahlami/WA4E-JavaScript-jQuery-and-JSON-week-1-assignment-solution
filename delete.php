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
    $stmt = $pdo->query("DELETE FROM profile WHERE profile_id=".$_POST['profile_id']);
    if($stmt !== false){
        $_SESSION['success'] = "Profile deleted successfully";
        header("Location: index.php");
        return;
    }else{
        $_SESSION['error'] = "Error while deleting profile";
        header("Location: index.php");
        return;
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
    <title>Mohamed Lahlami's Delete Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>Deleteing Profile</h1>
    </header>
    <p>Lirst Name: <?= htmlentities($profile['first_name']) ?></p>
    <p>Last Name: <?= htmlentities($profile['last_name']) ?></p>
    <form method="post">
        <input type="hidden" name="profile_id" value="<?= $profile['profile_id'] ?>">
        <input type="submit" name="submit" value="Delete">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</body>
</html>