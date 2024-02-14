<?php
    include("pdo.php");
    $profile_id = $_GET['profile_id'];
    $stmt = $pdo->query("SELECT * FROM profile WHERE profile_id = $profile_id");
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mohamed Lahlami's View Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header><h1>Profile information</h1></header>
    <p>First Name: <?=htmlentities($profile['first_name'])?></p>
    <p>Last Name: <?=htmlentities($profile['last_name'])?></p>
    <p>Email: <?=htmlentities($profile['email'])?></p>
    <p>Headline: <?=htmlentities($profile['headline'])?></p>
    <p>Summary: <?=htmlentities($profile['summary'])?></p>
    <a href="index.php">Done</a>
</body>
</html>