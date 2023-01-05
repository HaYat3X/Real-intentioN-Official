<?php

// セッション開始
session_start();

// 外部ファイルのインポート
require_once '../../../../../class/Session_calc.php';
require_once '../../../../../class/Register_calc.php';
require_once '../../../../../class/Validation_calc.php';
require_once '../../../../../function/functions.php';
require_once '../../../../../class/View_calc.php';
require_once '../../../../../class/Like_calc.php';
require_once '../../../../../class/Search_calc.php';
require_once '../../../../../class/Reserve_calc.php';


// インスタンス化
$ses_calc = new Session();
$val_calc = new ValidationCheck();
$rgs_calc = new Register();
$viw_calc = new View();
$lik_calc = new Like();
$srh_calc = new Search();
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

// ログイン情報がない場合リダイレクト
if (!$student_login_data) {
    $uri = '../../../../Exception/400_request.php';
    header('Location: ' . $uri);
}

// ユーザアイコンを抽出
foreach ($student_login_data as $row) {
    $user_icon = $row['icon'];
}

// POSTリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 送信された値の受け取り
    $search_category = filter_input(INPUT_POST, 'category');
    $search_keyword = filter_input(INPUT_POST, 'keyword');

    // 検索結果を取得
    $search_result = $srh_calc->briefing_information_search($search_category, $search_keyword);
} else {
    $uri = '../../../../Exception/400_request.php';
    header('Location:' . $uri);
}

// POSTリクエストがreserveだった場合予約する
if (isset($_POST['reserve'])) {

    // csrfトークンの存在確認
    $csrf_check = $ses_calc->csrf_match_check($_POST['csrf_token']);

    // csrfトークンの正誤判定
    if (!$csrf_check) {
        $uri = '../../../../Exception/400_request.php';
        header('Location:' . $uri);
    }

    // 予約する
    $rsv_calc->briefing_information_reserve($_POST['post_id'], $user_id);

    // csrf_token削除　二重送信対策
    $ses_calc->csrf_token_unset();
    $uri = '../posts_recommendation.php';
    header('Location: ' . $uri);
}

// POSTリクエストがreserve_deleteだった場合予約する
if (isset($_POST['reserve_delete'])) {

    // csrfトークンの存在確認
    $csrf_check = $ses_calc->csrf_match_check($_POST['csrf_token']);

    // csrfトークンの正誤判定
    if (!$csrf_check) {
        $uri = '../../../../Exception/400_request.php';
        header('Location:' . $uri);
    }

    // 予約解除
    $rsv_calc->briefing_information_reserve_delete($_POST['post_id'], $user_id);

    // csrf_token削除　二重送信対策
    $ses_calc->csrf_token_unset();
    $uri = '../posts_recommendation.php';
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
    <link rel="shortcut icon" href="../../../../../public/img/favicon.ico" type="image/x-icon">
    <title>会社説明会情報検索結果 /「Real intentioN」</title>
    <style>
        body {
            background-color: #EFF5F5;
        }

        header {
            background-color: #c2dbde;
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
    </style>
</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="">
                    <img src="../../../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                            align-text-top" style="object-fit: cover;"> Real intentioN
                </a>
            </div>
        </nav>
    </header>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12">
                <?php if (is_array($search_result) || is_object($search_result)) : ?>
                    <?php foreach ($search_result as $row) : ?>

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
                                    <div class="info-left col-lg-2 col-md-2 col-4">
                                        <div class="text-center">
                                            <div class="ratio ratio-1x1" style="background-color: #d9534f; border-radius: 5px;">
                                                <div class="fs-5 fw-bold d-flex align-items-center justify-content-center">
                                                    BRIEFING
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-10 col-md-10 col-8">
                                        <p class="fw-bold mt-1">
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

                                        <p class="fs-5 fw-bold">
                                            <?php h($row['company']) ?><span style="margin: 0 10px;">/</span><?php h($row['field']) ?><span style="margin: 0 10px;">/</span><?php h($row['format']) ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 px-4">
                                    <p>
                                        <span>
                                            <?php echo preg_replace('/\n/', "<br>",  $row['overview']); ?>
                                        </span>
                                    </p>

                                    <!-- 添付資料がある場合は表示する -->
                                    <?php if ($row['attachment']) : ?>
                                        <p class="pt-1">
                                            <!-- 正規表現でリンク以外の文字列はエスケープ、リンクはaタグで囲んで、遷移できるようにする。 -->
                                            <?php $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/'; ?>
                                            <?php $replace = '<a target="_blank" href="$1">$1</a>'; ?>
                                            <?php $attachment = preg_replace($pattern, $replace, $row['attachment']);  ?>

                                            <span>添付資料：<?php echo $attachment; ?></span>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-lg-1 col-md-1 col-2">
                                        <?php $reserve_check = $rsv_calc->briefing_information_reserve_check($row['post_id'], $user_id); ?>
                                        <?php $reserve_val = $rsv_calc->briefing_information_reserve_count($row['post_id']); ?>

                                        <?php if ($reserve_check) : ?>
                                            <form action="./search_result.php" method="post">
                                                <input type="hidden" name="post_id" value="<?php h($row['post_id']) ?>">
                                                <input type="hidden" name="student_id" value="<?php h($user_id) ?>">
                                                <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">
                                                <button class="btn fs-5" name="reserve_delete">
                                                    <i class="text-danger bi bi-calendar2-x-fill"></i>
                                                </button>
                                            </form>
                                        <?php else : ?>
                                            <form action="./search_result.php" method="post">
                                                <input type="hidden" name="post_id" value="<?php h($row['post_id']) ?>">
                                                <input type="hidden" name="student_id" value="<?php h($user_id) ?>">
                                                <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">
                                                <button class="btn fs-5" name="reserve">
                                                    <i class="bi bi-calendar2-plus"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($reserve_check) : ?>
                                        <div class="col-lg-4 col-md-4 col-4" style="margin-top: 10px;">
                                            <span class="fs-6">予約中</span>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-lg-4 col-md-4 col-4" style="margin-top: 10px;">
                                            <span class="fs-6">未予約</span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-lg-7 col-md-7 col-6 mt-2 text-end">
                                        <span class="fs-6">予約者数：<?php h($reserve_val) ?>人</span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="side-bar col-md-4 bg-light h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="../../intern_information/posts_recommendation.php" class="nav-link link-dark">
                                インターンシップ情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../posts_recommendation.php" class="nav-link link-dark">
                                会社説明会情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../../intern_experience/posts.php" class="nav-link link-dark">
                                インターンシップ体験記
                            </a>
                        </li>

                        <li>
                            <a href="../../es_experience/posts.php" class="nav-link link-dark">
                                ES体験記
                            </a>
                        </li>

                        <li>
                            <a href="../../intern_experience/post/post_form.php" class="nav-link link-dark">
                                インターンシップ体験記を投稿
                            </a>
                        </li>

                        <li>
                            <a href="../../es_experience/post/post_form.php" class="nav-link link-dark">
                                ES体験記を投稿
                            </a>
                        </li>
                    </ul>

                    <hr>

                    <div class="dropdown">
                        <div class="mb-4">
                            <form action="./search_result.php" method="post">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="フリーワード検索">
                                    <input type="hidden" name="category" value="overview">
                                    <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="mb-4">
                            <form action="./search_result.php" method="post">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="企業名で検索">
                                    <input type="hidden" name="category" value="company">
                                    <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="mb-4">
                            <form action="./search_result.php" method="post">
                                <div class="input-group">
                                    <select class="form-select" name="keyword" aria-label="Default select example">
                                        <option selected>開催形式で検索</option>
                                        <option value="対面開催">対面開催</option>
                                        <option value="オンライン開催">オンライン開催</option>
                                    </select>
                                    <input type="hidden" name="category" value="format">
                                    <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <div>
                            <form action="./search_result.php" method="post">
                                <div class="input-group">
                                    <select class="form-select" name="keyword" aria-label="Default select example">
                                        <option selected>業界で検索</option>
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
                            <?php if ($user_icon == "") : ?>
                                <img src="../../../../../public/ICON/default-icon.jpeg" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                            <?php else : ?>
                                <img src="../../../../../public/ICON/<?php h($user_icon) ?>" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                            <?php endif; ?>
                            <strong><?php h($user_name) ?></strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="../../profile/profile.php">プロフィール</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../../../../logout/logout.php">ログアウト</a></li>
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