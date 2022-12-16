<?php

// セッション開始
session_start();

// 外部ファイルのインポート
require_once '../../../../class/Session_calc.php';
require_once '../../../../class/Validation_calc.php';
require_once '../../../../function/functions.php';
require_once '../../../../class/View_calc.php';
require_once '../../../../class/Like_calc.php';
require_once '../../../../class/Reserve_calc.php';

// インスタンス化
$ses_calc = new Session();
$val_calc = new ValidationCheck();
$viw_calc = new View();
$lik_calc = new Like();
$rsv_calc = new Reserve();

// ログインチェック
$student_login_data = $ses_calc->student_login_check();

// ユーザIDを抽出
foreach ($student_login_data as $row) {
    $user_id = $row['student_id'];
}

// ユーザ名を抽出
foreach ($student_login_data as $row) {
    $user_name = $row['name'];
}

// 所属学科を抽出
foreach ($student_login_data as $row) {
    $user_course_of_study = $row['course_of_study'];
}

// ログイン情報がない場合リダイレクト
if (!$student_login_data) {
    $uri = '../../../Exception/400_request.php';
    header('Location: ' . $uri);
}

// GETで現在のページ数を取得する（未入力の場合は1を挿入）
if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}

// スタートのポジションを計算する
if ($page > 1) {
    $start = ($page * 10) - 10;
} else {
    $start = 0;
}

// インターンシップ情報投稿データを取得
$intern_information_data = $viw_calc->intern_information_data($start);

// インターンシップ情報のデータ数を取得
$page_num = $viw_calc->intern_information_data_val();

// ページネーションの数を取得する
$pagination = ceil($page_num / 10);

// 投稿に予約する
if (isset($_POST['reserve'])) {
    // csrfトークンの存在確認と正誤判定
    $csrf_check = $ses_calc->csrf_match_check($_POST['csrf_token']);
    if (!$csrf_check) {
        $uri = '../../../Exception/400_request.php';
        header('Location:' . $uri);
    }

    // csrf_token削除　二重送信対策
    $ses_calc->csrf_token_unset();

    $rsv_calc->intern_information_reserve($_POST['post_id'], $user_id);
    $uri = './posts_recommendation.php';
    header('Location: ' . $uri);
}

// 投稿情報に予約解除する
if (isset($_POST['reserve_delete'])) {
    // csrfトークンの存在確認と正誤判定
    $csrf_check = $ses_calc->csrf_match_check($_POST['csrf_token']);
    if (!$csrf_check) {
        $uri = '../../../Exception/400_request.php';
        header('Location:' . $uri);
    }

    $rsv_calc->intern_information_reserve_delete($_POST['post_id'], $user_id);

    // csrf_token削除　二重送信対策
    $ses_calc->csrf_token_unset();

    $uri = './posts_recommendation.php';
    header('Location: ' . $uri);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="../../../../public/img/favicon.ico" type="image/x-icon">
    <title>ES体験記 /「Real intentioN」</title>
    <style>
        body {
            background-color: #EFF5F5;
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
            background-color: #eb6540c4;
        }

        .square_box {
            position: relative;
            max-width: 100px;
            background: #ff3278;
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
    </style>
</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="">
                    <img src="../../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                            align-text-top" style="object-fit: cover;"> Real intentioN
                </a>
            </div>
        </nav>
    </header>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12">

                <a href="./posts_all.php" class="btn btn-primary">フィルターOFF</a>

                <?php if (is_array($intern_information_data) || is_object($intern_information_data)) : ?>
                    <?php foreach ($intern_information_data as $row) : ?>

                        <!-- 所属学科向けに発信されたおすすめ投稿のみ表示する falseにならない時が検索に引っかかる時-->
                        <?php $posts_recommendation = strpos($row['outgoing_course_of_study'], $user_course_of_study); ?>
                        <?php if ($posts_recommendation !== false) : ?>

                            <!-- 現在時刻との差を求め、開催まで後何日なのか計算 -->
                            <?php $objDateTime = new DateTime(); ?>
                            <?php $time = $objDateTime->format('Y-m-d'); ?>
                            <?php $time1 = new DateTime($time); ?>
                            <?php $time2 = new DateTime($row['time']); ?>
                            <?php $diff = $time1->diff($time2); ?>
                            <?php $limit = $diff->format('%R%a'); ?>
                            <?php $limit2 = $diff->format('%a'); ?>

                            <!-- 期日が過ぎた情報は表示しない -->
                            <?php if ($limit >= 1) : ?>
                                <div class="intern-contents mb-5 px-4 py-4 bg-light">
                                    <div class="row mt-3">
                                        <div class="info-left col-lg-2 col-md-2 col-2">
                                            <div class="text-center">
                                                <div class="square_box">
                                                    <p>ES</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-md-9 col-9">
                                            <p class="fw-bold">
                                                <?php if ($limit <= 7) : ?>
                                                    <span style="color: red;" class="fw-bold">
                                                        <?php h('予約締め切りまであと' . $limit2 . '日') ?>
                                                    </span>
                                                <?php else : ?>
                                                    <span class="fw-bold">
                                                        <?php h('予約締め切りまであと' . $limit2 . '日') ?>
                                                    </span>
                                                <?php endif; ?>
                                            </p>

                                            <p class="fs-5">
                                                <?php h($row['company']) ?><span style="margin: 0 10px;">/</span><?php h($row['field']) ?><span style="margin: 0 10px;">/</span><?php h($row['format']) ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-4 px-3">
                                        <p class="information">
                                            <span><?php h($row['overview']) ?></span>
                                        </p>

                                        <p class="pt-1">
                                            <?php
                                            // 正規表現でリンク以外の文字列はエスケープ、リンクはaタグで囲んで、遷移できるようにする。
                                            $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
                                            $replace = '<a target="_blank" href="$1">$1</a>';
                                            $attachment = preg_replace($pattern, $replace, $row['attachment']);
                                            ?>
                                            <span><?php echo $attachment; ?></span>
                                        </p>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-lg-1 col-md-1 col-1">
                                            <?php $reserve_check = $rsv_calc->intern_information_reserve_check($row['post_id'], $user_id); ?>
                                            <?php $reserve_val = $rsv_calc->intern_information_reserve_count($row['post_id']); ?>

                                            <?php if ($reserve_check) : ?>
                                                <form action="./posts_recommendation.php" method="post">
                                                    <input type="hidden" name="post_id" value="<?php h($row['post_id']) ?>">
                                                    <input type="hidden" name="student_id" value="<?php h($user_id) ?>">
                                                    <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">
                                                    <button class="btn fs-5" name="reserve_delete">
                                                        <i style="color: red;" class="bi bi-clipboard-check"></i>
                                                    </button>
                                                </form>
                                            <?php else : ?>
                                                <form action="./posts_recommendation.php" method="post">
                                                    <input type="hidden" name="post_id" value="<?php h($row['post_id']) ?>">
                                                    <input type="hidden" name="student_id" value="<?php h($user_id) ?>">
                                                    <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">
                                                    <button class="btn fs-5" name="reserve">
                                                        <i class="bi bi-clipboard"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($reserve_check) : ?>
                                            <div class="col-lg-4 col-md-4 col-5 mt-2">
                                                <span class="fs-6">予約中</span>
                                            </div>
                                        <?php else : ?>
                                            <div class="col-lg-4 col-md-4 col-5 mt-2">
                                                <span class="fs-6">未予約</span>
                                            </div>
                                        <?php endif; ?>

                                        <div class="col-lg-7 col-md-4 col-5 mt-2 text-end">
                                            <span class="fs-6">予約者数：<?php h($reserve_val) ?>人</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php if ($page > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php h($page - 1); ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;<?php h($page - 1); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($page < $pagination) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php h($page + 1); ?>" aria-label="Next">
                                    <span aria-hidden="true"><?php h($page + 1); ?>&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

            <div class="side-bar col-md-4 bg-light  h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="../staff_information/staff_information.php" class="nav-link link-dark">
                                インターンシップ情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../staff_information/staff_information.php" class="nav-link link-dark">
                                会社説明会情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../staff_information/staff_information.php" class="nav-link link-dark">
                                キャリアセンターからのお知らせ
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../intern_experience/posts.php" class="nav-link link-dark">
                                インターンシップ体験記
                            </a>
                        </li>

                        <li>
                            <a href="./posts.php" style="background-color: #EB6440;" class="nav-link active" aria-current="page">
                                ES体験記
                            </a>
                        </li>

                        <li>
                            <a href="./post/post_form.php" class="nav-link link-dark">
                                インターンシップ体験記を投稿
                            </a>
                        </li>

                        <li>
                            <a href="./post/post_form.php" class="nav-link link-dark">
                                ES体験記を投稿
                            </a>
                        </li>
                    </ul>

                    <hr>

                    <div class="dropdown">
                        <div class="mb-4">
                            <form action="./search/search_result.php" method="post">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="フリーワード検索">
                                    <input type="hidden" name="category" value="answer">
                                    <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="mb-4">
                            <form action="./search/search_result.php" method="post">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="企業名で検索">
                                    <input type="hidden" name="category" value="company">
                                    <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="mb-4">
                            <form action="./search/search_result.php" method="post">
                                <div class="input-group">
                                    <select class="form-select" name="keyword" aria-label="Default select example">
                                        <option selected>職種分野で検索</option>
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
                                    <input type="hidden" name="category" value="field">
                                    <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                            <strong><?php h($user_name) ?></strong>
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
    </div>

    <footer class="text-center py-3">
        <div class="text-light text-center small">
            &copy; 2022 Toge-Company, Inc
            <a class="text-white" target="_blank" href="https://hayate-takeda.xyz/">hayate-takeda.xyz</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
</body>

</html>