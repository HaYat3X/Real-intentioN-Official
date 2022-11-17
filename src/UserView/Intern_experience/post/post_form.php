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

// 学生の名前
$userName = $student_inst->get_student_name();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト　（不正なリクエストとみなす）
if (!$userId) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}

// 質問の配列
$array = [
    '体験内容について教えてください。',
    'インターンに参加は選考に有利になったと思いますか？',
    'index'
];

// ランダムに質問の配列の値を呼ぶ
$responses = $array[array_rand($array)];

?>


<!-- ------------------------------------------------------------------------------- -->

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

        .side-bar {
            padding-top: 10px;
            padding-bottom: 10px;
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
                <div class="bg-light">
                    <div class="mx-auto col-lg-8 pt-2 pb-5">
                        <form class="mt-5" action="./post_confirmation.php" method="post">
                            <h1 class="text-center fs-2 mb-5">インターン体験記を投稿する</h1>

                            <div class="mb-4">
                                <label class="form-label" for="name">企業名</label>
                                <input class="form-control" type="text" name="company" id="name">
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="name">体験内容</label>
                                <input class="form-control" type="text" name="content" id="name">
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="name">開催形式</label>
                                <select class="form-select" name="format" aria-label="Default select example">
                                    <option selected>-- 選択してください --</option>
                                    <option value="オンライン開催">オンライン開催</option>
                                    <option value="対面開催">対面開催</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="name">参加した分野</label>
                                <select class="form-select" name="field" aria-label="Default select example">
                                    <option selected>-- 選択してください --</option>
                                    <option value="IT分野">IT分野</option>
                                    <option value="ゲームソフト分野">ゲームソフト分野</option>
                                    <option value="ハード分野">ハード分野</option>
                                    <option value="ビジネス分野">ビジネス分野</option>
                                    <option value="CAD分野">CAD分野</option>
                                    <option value="グラフィックス分野">グラフィックス分野</option>
                                    <option value="サウンド分野">サウンド分野</option>
                                    <option value="日本語分野">日本語分野</option>
                                    <option value="国際コミュニケーション分野">国際コミュニケーション分野</option>
                                </select>
                            </div>


                            <div class="mb-4">
                                <label class="form-label" for="name">質問内容を選択してください</label>
                                <select class="form-select" name="question" aria-label="Default select example">
                                    <option selected>-- 選択してください --</option>
                                    <option value="インターンの参加は選考に有利になったと感じますか？その理由も教えてください。">インターンの参加は選考に有利になったと感じますか？その理由も教えてください。</option>
                                    <option value="インターンで体験した内容を教えてください。">インターンで体験した内容を教えてください。</option>
                                    <option value="交通費の支給など、金銭面でのサポートはありましたか？">交通費の支給など、金銭面でのサポートはありましたか？</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="exampleFormControlTextarea1" class="form-label">選択した質問に回答してください。</label>
                                <textarea class="form-control" name="answer" id="exampleFormControlTextarea1" rows="5" style="resize: none;"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="name">総合評価（5段階で選択してください。）</label>
                                <select class="form-select" name="ster" aria-label="Default select example">
                                    <option selected>-- 選択してください --</option>
                                    <option value="星1">星1</option>
                                    <option value="星2">星2</option>
                                    <option value="星3">星3</option>
                                    <option value="星4">星4</option>
                                    <option value="星5">星5</option>
                                </select>
                            </div>

                            <input type="hidden" name="user_id" value="<?php h($userId) ?>">

                            <button type="submit" class="login-btn btn px-4">入力内容を確認する</button>
                        </form>
                    </div>
                </div>
            </div>


            <div class="side-bar col-md-4 bg-light sticky-top h-100">
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
        </div>
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