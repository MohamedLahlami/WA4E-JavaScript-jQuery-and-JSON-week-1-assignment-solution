<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mohamed Lahlami's Index Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <header>
        <h1>Mohamed Lahlami's Resume registry</h1>
    </header>
<?php
    include("pdo.php");
    session_start();
    if (!isset($_SESSION["user_id"])) { 
        echo "<a href='login.php'>Please log in</a>";
        return;
    }
    echo "<p><a href='logout.php'>Logout</a></p>";
    if(isset($_SESSION['success'])){
        echo '<p style="color: green;">'.$_SESSION['success'].'</p>';
        unset($_SESSION['success']);
    }
    if(isset($_SESSION['error'])){
        echo '<p style="color: red;">'.$_SESSION['error'].'</p>';
        unset($_SESSION['error']);
    }
    $stmt = $pdo->query('SELECT * FROM Profile WHERE user_id = '.$_SESSION["user_id"]);
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($profiles)) {
        echo "<table><tr><th>Name</th><th>Headline</th><th>Action</th></tr>";
        foreach($profiles as $profile){
            echo "
            <tr>
                <td><a href='view.php?profile_id=".$profile['profile_id']."'>".htmlentities($profile['first_name']).' '.htmlentities($profile['last_name'])."</a></td>
                <td>".htmlentities($profile['headline'])."</td>
                <td>
                    <a href='edit.php?profile_id=".htmlentities($profile['profile_id'])."'>Edit</a>
                    <a href='delete.php?profile_id=".htmlentities($profile['profile_id'])."'>Delete</a>
                </td>
            </tr>
            ";
        }
        echo "</table>";
    }
?>
        <p><a href="add.php">Add New Entry</a></p>
    </body>
</html>