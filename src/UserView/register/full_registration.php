<?php

session_start();

// 外部ファイルおインポート
require __DIR__ . '../../../../class/Logic.php';
require __DIR__ . '../../../../function/functions.php';

// クラスのインポート
$object = new SystemLogic();

// errメッセージが格納される配列を定義
$err_array = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // バリーデーションチェック
    if (!$password = filter_input(INPUT_POST, 'password')) {
        $err_array[] =  'パスワードを入力してください。';
    }

    if (!$name = filter_input(INPUT_POST, 'name')) {
        $err_array[] =  '名前を入力してください。';
    }

    if (!$department = filter_input(INPUT_POST, 'department')) {
        $err_array[] =  '学科を入力してください。';
    }

    if (!$school_year = filter_input(INPUT_POST, 'school_year')) {
        $err_array[] =  '学年を入力してください。';
    }

    if (!$number = filter_input(INPUT_POST, 'number')) {
        $err_array[] =  '出席番号を入力してください。';
    }

    if (!preg_match("/\A[a-z\d]{6,100}+\z/i", filter_input(INPUT_POST, 'password'))) {
        $err_array[] = 'パスワードは英数字6文字以上で作成してください。';
    }

    // エラーが一つもない場合ユーザ登録する
    if (count($err_array) === 0) {

        // 登録する情報を配列で処理
        $insert_data = [];
        $insert_data[] = strval($_POST['name']);
        $insert_data[] = strval($_POST['email']);
        $insert_data[] = strval(password_hash($_POST['password'], PASSWORD_DEFAULT));
        $insert_data[] = strval($_POST['department']);
        $insert_data[] = strval($_POST['school_year']);
        $insert_data[] = strval($_POST['number']);
        $insert_data[] = strval('活動中');

        // SQL発行
        $sql = 'INSERT INTO `student_master`(`name`, `email`, `password`, `department`, `school_year`, `number`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?)';

        // 登録処理
        $hasCreated = $object::db_insert($sql, $insert_data);

        if (!$hasCreated) {
            $err_array[] = '登録できませんでした';
        }
    }
} else {
    header('Location: ./provisional_registration_form.php');
}

?>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #e6e6e6;
        }

        .err-msg {
            margin-top: 150px;
            background-color: white;
            padding: 30px 50px;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light py-4">
            <div class="container">
                <a class="navbar-brand" href="#">Real intentioN</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">職員の方はこちら</a>
                        </li>
                        <button class="btn btn-primary ms-3">ログインはこちら</button>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="main d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="mx-auto col-lg-6">
                    <div class="err-msg">
                        <?php if (count($err_array) > 0) : ?>
                            <?php foreach ($err_array as $err_mag) : ?>
                                <p style="color: red;"><?php h($err_mag); ?></p>
                            <?php endforeach; ?>
                            <div class="backBtn">
                                <a class="btn btn-primary px-5" href="./full_registration_form.php?key=<?php h($_POST['email']) ?>">戻る</a>
                            </div>
                        <?php endif; ?>

                        <?php if (count($err_array) === 0) : ?>
                            <label>ユーザ登録が完了しました。</label>
                            <?php header('refresh:3;url=../login/login_form.php'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
<!-- 
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../public/css/register/auth.css">
    <title>「Real intentioN」 / 新規会員登録</title>
</head>

<body>

    <div class="err">
        <?php if (count($err) > 0) : ?>
            <?php foreach ($err as $e) : ?>
                <label><?php h($e); ?></label>
            <?php endforeach; ?>
            <div class="backBtn">
                <a href="./full_registration_form.php?key=<?php h($_POST['email']) ?>">戻る</a>
            </div>
        <?php endif; ?>

        <?php if (count($err) === 0) : ?>
            <label>ユーザ登録が完了しました。</label>
           
        <?php endif; ?>
    </div>
</body>

</html> -->