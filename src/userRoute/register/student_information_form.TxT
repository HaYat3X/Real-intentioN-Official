<?php

// セッションスタート
session_start();

// セッション情報があるか判定をする
if (!isset($_SESSION['access_token'])) {
    $_SESSION['err'] = '不正なリクエストです';
    header('Location: auth_form.php');
    exit();
}

$email = $_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../public/css/register/student_infomation.css">
    <title>「Real intentioN」 / 新規会員登録</title>
</head>

<body>

    <?php include '/Applications/MAMP/htdocs/Deliverables3/public/template/header.html'; ?>

    <div class="authContent">
        <h2>学生情報登録</h2>
        <form action="./student_information.php" method="post">
            <p><span>必須</span><label style="margin-right: 30px;">ニックネーム</label><input type="text" name="name" required></p>

            <p>
                <span>必須</span><label style="margin-right: 93px;">学科名</label>
                <select name="department" required>
                    <option hidden>選択してください</option>
                    <option value="ITエキスパート学科">ITエキスパート学科</option>
                    <option value="ITスペシャリスト学科">ITスペシャリスト学科</option>
                </select>
            </p>

            <p>
                <span>必須</span><label style="margin-right: 113px;">学年</label>
                <select name="school_year" required>
                    <option hidden>選択してください</option>
                    <option value="1年生">1年生</option>
                    <option value="2年生">2年生</option>
                </select>
            </p>

            <p><span>必須</span><label style="margin-right: 68px;">出席番号</label><input type="text" name="number" required></p>

            <p><span>必須</span><label style="margin-right: 48px;">パスワード</label><input type="password" name="password" required></p>

            <!-- email情報 -->
            <input type="hidden" name="email" value="<?php echo $email; ?>">

            <button type="submit">登録する</button>
        </form>
    </div>
</body>

</html>