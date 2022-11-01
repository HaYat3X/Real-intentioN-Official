<?php

// データベースロジックファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/class/DatabaseLogic.php';

// ユーザロジッククラス
class StaffLogic
{
    // メールアドレスがDBに存在するか判定する
    public static function emailCheck($email)
    {
        // データベースクラス呼び出し
        $obj = new DatabaseLogic();

        $sql = 'SELECT * FROM staff_master WHERE email = ?';
        $result = $obj::databaseSelect($sql, $email);

        if ($result) {
            return $result;
        }

        return false;
    }

    // ログインメソッド
    public static function login($email, $password)
    {
        // メールアドレスが存在するか判定する
        $userData = self::emailCheck($email);

        // データが存在しない(返り値がTrue)であればエラーとする
        if (!$userData) {
            return false;
        }

        // データが存在した場合パスワード認証を行う
        if ($userData) {
            // DBのパスワードを取得
            foreach ($userData as $row) {
                $db_password = $row['password'];
            }

            // とりあえず完全一致で実装
            if ($password === $db_password) {
                //ログイン成功の場合 trueを返す
                session_regenerate_id(true);
                $_SESSION['login_staff'] = $userData;
                return $_SESSION['login_staff'];
            } else {
                return false;
            }
        }
    }
}
