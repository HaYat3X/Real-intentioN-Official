<?php

// DB接続ファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/function/connect_db.php';

// ユーザロジッククラス
class UserLogic
{
    // メールアドレスバリデーションチェック
    public static function emailValidation($email)
    {
        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@st.kobedenshi.ac.jp/", $email)) {
            return true;
        } else {
            return false;
        }
    }
}

// インターンロジッククラス
class InternStudentLogic
{
}

// データベースロジッククラス
class DatabaseLogic
{
}
