<?php

session_start();

require '/Applications/MAMP/htdocs/Deliverables4/class/Session_calc.php';
require '../../../function/functions.php';

$ses_calc = new Session();

$email_token = $ses_calc->check_email_token();
var_dump($email_token);

if (!$email_token) {
    $uri = '';
    // header('Location:' . $uri);
    echo '不正なリクエスト';
}

$email = filter_input(INPUT_GET, 'email');


// // セッション消去
// $ses_calc->email_token_unset();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=ƒ, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="./auth_email.php" method="post">
        <input type="text" name="token">
        <input type="hidden" name="email" value="<?php h($email); ?>">
        <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">
        <input type="hidden" name="email_token" value="<?php h($email_token); ?>">
        <button type="submit">認証</button>
    </form>
</body>

</html>