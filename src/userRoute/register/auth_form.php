<?php
session_start();


$err = $_SESSION['err'];
error_reporting(0);
if(isset($err)){

    echo '不正なリクエストです';
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="./auth.php" method="post">
        email<input type="text" name="email" required>
        <button type="submit">認証する</button>
    </form>
</body>

</html>