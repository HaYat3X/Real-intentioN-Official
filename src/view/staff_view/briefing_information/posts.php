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
$staff_login_data = $ses_calc->staff_login_check();

// ユーザIDを抽出
foreach ($staff_login_data as $row) {
    $user_id = $row['staff_id'];
}

// ユーザ名を抽出
foreach ($staff_login_data as $row) {
    $user_name = $row['name'];
}

// ログイン情報がない場合リダイレクト
if (!$staff_login_data) {
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

// 会社説明会情報投稿データを取得
$intern_information_data = $viw_calc->briefing_information_data($start);

// 会社説明会情報のデータ数を取得
$page_num = $viw_calc->briefing_information_data_val();

// ページネーションの数を取得する
$pagination = ceil($page_num / 10);

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
    <title>会社説明会情報 /「Real intentioN」</title>
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

    <script>
        function alertFunction1(value) {
            var submit = confirm("本当に削除しますか？");

            if (submit) {
                window.location.href = './delete/delete.php?post_id=' + value;
            } else {
                window.location.href = './posts.php';
            }
        }
    </script>
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
                <?php if (is_array($intern_information_data) || is_object($intern_information_data)) : ?>
                    <?php foreach ($intern_information_data as $row) : ?>
                        <div class="intern-contents mb-5 px-4 py-4 bg-light">
                            <div class="row mt-3">
                                <div class="info-left col-lg-2 col-md-2 col-4">
                                    <div class="text-center">
                                        <div class="ratio ratio-1x1" style="background-color: #ffb6b9; border-radius: 5px;">
                                            <div class="fs-5 text-light fw-bold d-flex align-items-center justify-content-center">
                                                BRIEFING
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-10 col-md-10 col-8">
                                    <p class="mt-2">
                                        <?php h($row['time']) ?>
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

                                <p class="pt-1">
                                    <?php $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/'; ?>
                                    <?php $replace = '<a target="_blank" href="$1">$1</a>'; ?>
                                    <?php $attachment = preg_replace($pattern, $replace, $row['attachment']);
                                    ?>
                                    <span>添付資料：<?php echo $attachment ?></span>
                                </p>
                            </div>

                            <?php $reserve_val = $rsv_calc->briefing_information_reserve_count($row['post_id']); ?>

                            <div class="mt-4 mb-3">
                                <a class="btn px-4 login-btn" href="./update/update_form.php?post_id=<?php h($row['post_id']) ?>">編集する</a>
                                <button class="btn login-btn px-4" value="<?php h($row['post_id']) ?>" onclick="alertFunction1(this.value)">削除する</button>
                                <a class="btn px-4 login-btn" href="./reserve/reserve_list.php?post_id=<?php h($row['post_id']); ?>">予約者一覧 <span class="badge text-dark bg-light"><?php h($reserve_val); ?></span></a>
                            </div>
                        </div>
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

            <div class="side-bar col-md-12 col-12 col-lg-4 bg-light h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="../intern_information/posts.php" class="nav-link link-dark">
                                インターンシップ情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./posts.php" style="background-color: #EB6440;" class="nav-link active" aria-current="page">
                                会社説明会情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../kic_information/posts.php" class="nav-link link-dark">
                                キャリアセンターからのお知らせ
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../intern_information/post/post_form.php" class="nav-link link-dark">
                                インターンシップ情報を投稿
                            </a>
                        </li>

                        <li>
                            <a href="./post/post_form.php" class="nav-link link-dark">
                                会社説明会情報を投稿
                            </a>
                        </li>

                        <li>
                            <a href="../kic_information/post/post_form.php" class="nav-link link-dark">
                                キャリアセンターからのお知らせを投稿
                            </a>
                        </li>
                    </ul>

                    <hr>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../../../../public/ICON/default-icon.jpeg" alt="" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                            <strong><?php h($user_name) ?></strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="../../../logout/logout.php">ログアウト</a></li>
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