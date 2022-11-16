<?php

session_start();

// 外部ファイルのインポート
require '../../../../class/SystemLogic.php';
require __DIR__ . '../../../../../function/functions.php';

// インスタンス化
$val_inst = new DataValidationLogics();
$arr_prm_inst = new ArrayParamsLogics();
$db_inst = new DatabaseLogics();
$student_inst = new StudentLogics();

// ログインチェック
$userId = $student_inst->get_student_id();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト　（不正なリクエストとみなす）
if (!$userId) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}

// 編集する投稿IDの取得
$post_id = filter_input(INPUT_GET, 'post_id');
$argument = $arr_prm_inst->student_post_one_prm($post_id);

// SQL発行
$sql = 'SELECT * FROM `intern_table` INNER JOIN `student_master` ON intern_table.user_id = student_master.student_id AND intern_table.post_id = ?';

// 編集するデータを取得
$update_date = $db_inst->data_select_argument($sql, $argument);

// 学生の名前
$userName = $student_inst->get_student_name();

// 編集対象データがない場合はリダイレクト
if (!$update_date) {
    $url = '../../../Incorrect_request.php';
    header('Location:' . $url);
}

// 投稿者IDとログイン中のユーザのIDが一致しなければリダイレクト
foreach ($update_date as $row) {
    if (!$userId == $row['user_id']) {
        $url = '../../../Incorrect_request.php';
        header('Location:' . $url);
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../public/css/intern/view.css">
    <title>「Real intentioN」 / インターン体験記</title>
    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #e6e6e6;
        }

        header {
            background-color: #D6E4E5;
        }

        footer {
            background-color: #D6E4E5;
        }

        .nav-link {
            font-weight: bold;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .login-btn {
            background-color: #EB6440;
            color: white;
        }

        .login-btn:hover {
            color: white;
            background-color: #eb6540c1;
        }

        .box {
            background-color: white;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="../../../index.html">
                    <img src="../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;">
                    Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">Real intentioNとは</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">お問い合わせはこちら</a>
                        </li>
                    </ul>
                </div>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../../StaffView/login/login_form.php">職員の方はこちら</a>
                        </li>

                        <li class="nav-item">
                            <a class="login-btn btn" href="./login_form.php">ログインはこちら</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>



    <main role="main" class="container my-5" style="padding: 0px">
        <div class="row">
            <div class="col-md-8">
                <?php if (is_array($update_date) || is_object($update_date)) : ?>
                    <?php foreach ($update_date as $row) : ?>
                        <div class="bg-light py-3">
                            <div class="mx-auto col-lg-8">
                                <form class="mt-5" action="./update_confirmation.php?post_id=<?php h($post_id) ?>" method="post">
                                    <h1 class="text-center fs-2 mb-5">インターン体験記を編集する</h1>

                                    <div class="mb-4">
                                        <label class="form-label" for="name">企業名</label>
                                        <input class="form-control" type="text" name="company" value="<?php h($row['company']) ?>" id="name">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for="name">体験内容</label>
                                        <input class="form-control" type="text" name="content" value="<?php h($row['content']) ?>" id="name">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for="name">参加形式</label>
                                        <select class="form-select" name="format" aria-label="Default select example">
                                            <option selected><?php h($row['format']) ?></option>
                                            <option value="オンライン形式">オンライン形式</option>
                                            <option value="対面形式">対面形式</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for="name">参加形式</label>
                                        <select class="form-select" name="field" aria-label="Default select example">
                                            <option selected><?php h($row['field']) ?></option>
                                            <option value="IT・ソフトウェア">IT・ソフトウェア</option>
                                            <option value="対面形式">対面形式</option>
                                        </select>
                                    </div>


                                    <div class="mb-4">
                                        <label class="form-label" for="name">質問内容を選択してください</label>
                                        <!-- <input class="form-control" type="text" name="question" readonly value="<?php h($responses) ?>" id="name"> -->
                                        <select class="form-select" name="question" aria-label="Default select example">
                                            <option selected><?php h($row['question']) ?></option>
                                            <option value="インターンの参加は選考に有利になったと感じますか？その理由も教えてください。">インターンの参加は選考に有利になったと感じますか？その理由も教えてください。</option>
                                            <option value="インターンで体験した内容を教えてください。">インターンで体験した内容を教えてください。</option>
                                            <option value="自分が思っていた業界とのギャップは">内容選考中</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="exampleFormControlTextarea1" class="form-label">質問回答</label>
                                        <textarea class="form-control" name="answer" id="exampleFormControlTextarea1" rows="5" style="resize: none;"><?php h($row['answer']) ?></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for="name">総合評価</label>
                                        <select class="form-select" name="ster" aria-label="Default select example">
                                            <option selected>星<?php h($row['ster']) ?></option>
                                            <option value="1">星1</option>
                                            <option value="2">星2</option>
                                            <option value="3">星3</option>
                                            <option value="4">星4</option>
                                            <option value="5">星5</option>
                                        </select>
                                    </div>

                                    <input type="hidden" name="user_id" value="<?php h($userId) ?>">

                                    <button type="submit" class="login-btn btn px-4">入力内容を確認する</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- 
            <div class="col-md-4 bg-warning sticky-top vh-100">
                <div>
                    <h1>送信</h1>
                </div>
            </div> -->
            <div class="side-bar col-md-4 bg-light sticky-top vh-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a style="background-color: #EB6440;" href="./view.php" class="nav-link active" aria-current="page">
                                インターン体験記
                            </a>
                        </li>
                        <li>
                            <a href="../staff_information/staff_information.php" class="nav-link link-dark">
                                インターン / イベント情報 / 説明会情報
                            </a>
                        </li>
                    </ul>



                    <hr>
                    <div class="dropdown">
                        検索BOX
                    </div>

                    <hr>
                    <div class="dropdown">
                        人気の情報を表示
                    </div>

                    <hr>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                            <strong><?php h($userName) ?></strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="#">プロフィール</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../logout.php">サインアウト</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div><!-- Div row 終了-->
    </main>

    <footer>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="../../../index.html">
                    <img src="../../../public/img" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;">
                    Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav2">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">職員の方はこちら</a>
                        </li>

                        <li class="nav-item">
                            <a class="login-btn btn" href="./src/UserView/login/login_form.php">ログインはこちら</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>