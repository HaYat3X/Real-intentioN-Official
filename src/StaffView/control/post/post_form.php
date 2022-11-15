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
            background-color: #e6e6e6;
        }



        .square_box {
            position: relative;
            max-width: 100px;
            background: #ffb6c1;
        }

        .square_box::before {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .square_box p {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .side-area {
            position: sticky;
            top: 60px;
        }
    </style>
</head>

<body>

    <!-- テスト-------------------------------------------------------------------------------------------- -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light py-4">
            <div class="container">
                <img style="width: 45px; height:45px; margin-right:10px;" src="../../../public/img/logo.png" alt="">
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



    <main role="main" class="container mt-5" style="padding: 0px">
        <div class="row">


            <div class="col-md-8">
                <div class="bg-light py-3">
                    <div class="mx-auto col-lg-8">
                        <form class="mt-5" action="./post_confirmation.php" method="post">

                            <div class="mb-2">
                                <label class="form-label" for="name">投稿情報の種類</label>
                                <select class="form-select" name="type" aria-label="Default select example">
                                    <option selected>-- 選択してください --</option>
                                    <option value="インターン">インターン情報</option>
                                    <option value="イベント">イベント情報</option>
                                </select>
                            </div>



                            <div class="mb-2">
                                <label class="form-label" for="name">イベント形式</label>
                                <select class="form-select" name="format" aria-label="Default select example">
                                    <option selected>-- 選択してください --</option>
                                    <option value="オンライン形式">オンライン形式</option>
                                    <option value="対面形式">対面形式</option>
                                </select>
                            </div>



                            <div class="mb-2">
                                <label class="form-label" for="name">イベント分野</label>
                                <select class="form-select" name="field" aria-label="Default select example">
                                    <option selected>-- 選択してください --</option>
                                    <option value="IT・ソフトウェア">IT・ソフトウェア</option>
                                    <option value="対面形式">対面形式</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label" for="name">イベント日時</label>
                                <input class="form-control" type="date" name="time" id="name">
                            </div>


                            <div class="mb-2">
                                <label class="form-label" for="name">企業名</label>
                                <input class="form-control" type="text" name="company" id="name">
                            </div>



                            <div class="mb-2">
                                <label for="exampleFormControlTextarea1" class="form-label">イベント内容</label>
                                <textarea class="form-control" name="overview" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>


                            <div class="mb-2">
                                <label for="exampleFormControlTextarea1" class="form-label">添付資料</label>
                                <input class="form-control" type="text" name="attachment" id="">
                            </div>

                            <button type="submit" class="btn btn-primary px-5">入力内容を確認する</button>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-md-4 bg-warning sticky-top vh-100">
                <div>
                    <h1>送信</h1>
                </div>
                <!-- <ul class=" list-group">
                    <li class="list-group-item list-group-item-light">Latest Posts</li>
                    <li class="list-group-item list-group-item-light">Announcements</li>
                </ul> -->
            </div><!-- col-md-4 終了-->



        </div><!-- Div row 終了-->
    </main>
    <!-- </div> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>