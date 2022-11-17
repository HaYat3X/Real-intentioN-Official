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

// 学生の名前
$userName = $student_inst->get_student_name();

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = filter_input(INPUT_POST, 'keyword');
} else {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}


// インターンテーブルのデータを全部stうとく
$sql = 'SELECT * FROM `intern_table` INNER JOIN `student_master` ON intern_table.user_id = student_master.student_id WHERE intern_table.company LIKE ? ORDER BY intern_table.post_id DESC';


// バインド
$argument = $arr_prm_inst->post_search_prm($keyword);

$results = $db_inst->data_select_argument($sql, $argument);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../public/img/favicon.ico" type="image/x-icon">
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

        .square_box {
            position: relative;
            max-width: 100px;
            background: #ffb6b9;
            border-radius: 5px;
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
            font-weight: bold;
        }

        .intern-contents {
            background-color: white;
            border-radius: 5px;
        }

        .area1 p {
            font-weight: bold;
        }

        .student-review {
            color: #FCCA4D;
        }

        .side-bar {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
    <title>「Real IntentioN」 / インターン体験記</title>
</head>

<body>
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


    <main role="main" class="container mt-5 mb-5">

        <div class="mb-4">
            <a class="login-btn btn px-4 py-3" href="./post/post_form.php">インターン体験記を投稿する</a>
        </div>

        <div class="row">
            <div class="col-md-8">


                <?php if (is_array($results) || is_object($results)) : ?>
                    <?php foreach ($results as $row) : ?>
                        <div class="intern-contents mb-5">


                            <div class="area1 d-flex px-3 py-4">
                                <div class="info-left col-2">
                                    <div class="square_box">
                                        <p>INTERN</p>
                                    </div>
                                </div>

                                <div class="info-center col-9">
                                    <p class="fs-5">
                                        <?php h($row['company']) ?><span style="margin: 0 10px;">/</span><?php h($row['field']) ?><span style="margin: 0 10px;">/</span><?php h($row['format']) ?>
                                    </p>

                                    <span><?php h($row['content']) ?></span>
                                    <br>
                                    <span class="student-review">
                                        <?php if ($row['ster'] === '星1') : ?>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                            <i class="bi bi-star"></i>
                                            <i class="bi bi-star"></i>
                                            <i class="bi bi-star"></i>
                                        <?php elseif ($row['ster'] === '星2') : ?>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                            <i class="bi bi-star"></i>
                                            <i class="bi bi-star"></i>
                                        <?php elseif ($row['ster'] === '星3') : ?>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                            <i class="bi bi-star"></i>
                                        <?php elseif ($row['ster'] === '星4') : ?>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                        <?php elseif ($row['ster'] === '星5') : ?>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        <?php endif; ?>
                                    </span>
                                </div>

                                <div class="info-right col-1 ms-4">

                                    <div class="text-center">
                                        <div class="btn-group">
                                            <?php if ($userId == $row['user_id']) : ?>
                                                <div class="btn-group dropstart" role="group">
                                                    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-dark">
                                                        <li><a href="./delete/delete_check.php?post_id=<?php h($row['post_id']) ?>" class="dropdown-item">削除</a></li>
                                                        <li><a class="dropdown-item" href="./update/update_form.php?post_id=<?php h($row['post_id']) ?>">編集</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="question px-5">
                                <p style="font-weight: bold;">
                                    <span style="color: blue;">Q.　</span>
                                    <?php h($row['question']) ?>
                                </p>
                            </div>

                            <div class="answer px-5">
                                <p>
                                    <span style="color: red; font-weight: bold;">A.　</span>
                                    <span style="word-break: break-all; white-space: pre-line;"><?php h($row['answer']) ?></span>
                                </p>
                            </div>

                            <div class="area2 d-flex px-3 py-4">
                                <div class="question-btn col-5">
                                    <a href="./comment/comment.php?post_id=<?php h($row['post_id']) ?>" class="login-btn btn px-4">投稿者に質問する</a>
                                </div>

                                <div class="post-name col-7 pt-2">
                                    <p class="text-end">
                                        <?php h($row['name']) ?> ｜ <?php h($row['department']) ?> ｜ <?php h($row['school_year']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>

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


        <!-- ページネーション -->
        <div class="justify-content-center">
            <nav aria-label="Page navigation example justify-content-center">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
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