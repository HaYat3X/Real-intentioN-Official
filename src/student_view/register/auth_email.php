<?php

session_start();

require '../../../class/Session_calc.php';
$ses_calc = new Session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $user_input_token = filter_input(INPUT_POST, 'token');
    $email_token = filter_input(INPUT_POST, 'email_token');
    $csrf_token = filter_input(INPUT_POST, 'csrf_token');

    // csrfトークンの存在確認と正誤判定
    $csrf_check = $ses_calc->csrf_match_check($csrf_token);
    // if (!$csrf_check) {
    //     $uri = '/Deliverables4/src/' . basename('400_request.php');
    //     header('Location:' . $uri);
    // }


    if ($email_token !== $user_input_token) {
        echo 'err';
    }

    // パラメータ付きでメールアドレス送信
} else {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>