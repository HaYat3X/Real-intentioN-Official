<?php


session_start();

// 外部ファイルのインポート
require '../../../../class/SystemLogic.php';
require '../../../../function/functions.php';

// インスタンス化
$val_inst = new DataValidationLogics();
$arr_prm_inst = new ArrayParamsLogics();
$db_inst = new DatabaseLogics();
$student_inst = new StaffLogics();

// ログインチェック
$userId = $student_inst->get_staff_id();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト　（不正なリクエストとみなす）
if (!$userId) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
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
            background-color: #eaf0f0;
        }

        header {
            background-color: #D6E4E5;
        }

        footer {
            background-color: #497174;
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

        .square_box_intern {
            position: relative;
            max-width: 100px;
            background: #ffb6b9;
            border-radius: 5px;
        }

        .square_box_intern::before {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .square_box_intern p {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
        }

        .square_box_briefing {
            position: relative;
            max-width: 100px;
            background: #fae3d9;
            border-radius: 5px;
        }

        .square_box_briefing::before {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .square_box_briefing p {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
        }

        .square_box_event {
            position: relative;
            max-width: 100px;
            background: #bbded6;
            border-radius: 5px;
        }

        .square_box_event::before {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .square_box_event p {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
        }

        .student-review {
            color: #FCCA4D;
        }

        .side-bar {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .like {
            color: black;
            font-size: 25px;
        }

        .like:hover {
            color: pink;
            font-size: 25px;
        }

        .unsubscribe {
            color: pink;
            font-size: 25px;
        }

        .unsubscribe:hover {
            color: pink;
            font-size: 25px;
        }

        /* ユーザの開業を判定し、そのまま出す */
        .information {
            word-break: break-all;
            white-space: pre-line;
        }

        .simple {
            width: 500px;
            /* 省略せずに表示するサイズを指定 */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .simple-box {
            background-color: #eaf0f0;
        }
    </style>
</head>

<body>

    <!-- テスト-------------------------------------------------------------------------------------------- -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="./view.php">
                    <img src="../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;">
                    Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>


    <!-- <div class="bg-light"> -->
    <main role="main" class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-8">
                <div class="bg-light py-3">
                    <div class="mx-auto col-lg-8">
                        <form class="mt-5 mb-5" action="./post_confirmation.php" method="post">
                            <h1 class="text-center fs-2 mb-5">情報を投稿する</h1>
                            <div class="mb-4">
                                <label class="form-label" for="name">投稿情報の種類</label>
                                <select class="form-select" name="type" aria-label="Default select example">
                                    <option selected>-- 選択してください --</option>
                                    <option value="インターン情報">インターン情報</option>
                                    <option value="説明会情報">説明会情報</option>
                                </select>
                            </div>



                            <div class="mb-4">
                                <label class="form-label" for="name">イベント形式</label>
                                <select class="form-select" name="format" aria-label="Default select example">
                                    <option selected>-- 選択してください --</option>
                                    <option value="オンライン開催">オンライン開催</option>
                                    <option value="対面開催">対面開催</option>
                                </select>
                            </div>



                            <div class="mb-4">
                                <label class="form-label" for="name">イベント分野</label>
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
                                <label class="form-label" for="name">イベント開催日時</label>
                                <input class="form-control" type="date" name="time" id="name">
                            </div>


                            <div class="mb-4">
                                <label class="form-label" for="name">企業名</label>
                                <input class="form-control" type="text" name="company" id="name">
                            </div>



                            <div class="mb-4">
                                <label for="exampleFormControlTextarea1" class="form-label">イベント内容</label>
                                <textarea class="form-control" name="overview" id="exampleFormControlTextarea1" rows="8"></textarea>
                            </div>


                            <div class="mb-4">
                                <label for="exampleFormControlTextarea1" class="form-label">添付資料（PDFやHPなど）</label>
                                <input class="form-control" type="text" name="attachment" id="">
                            </div>

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
                                ホーム
                            </a>
                        </li>
                        <li>
                            <a href="./post/post_form.php" class="nav-link link-dark">
                                情報新規投稿
                            </a>
                        </li>

                        <li>
                            <a href="../staff_information/staff_information.php" class="nav-link link-dark">
                                ログアウト
                            </a>
                        </li>
                    </ul>
                </div>
            </div>




        </div><!-- Div row 終了-->
    </main>
    <!-- </div> -->

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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>