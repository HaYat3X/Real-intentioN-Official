<?php

// DB接続ファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/function/connect_db.php';

// -----------------------------------------------------------------------------------------------------------------

// ユーザ情報を扱うクラス
class UserLogic
{
    // メールアドレスが存在するか確認する
    public static function user_exist_check($email)
    {
        $db_obj = new DatabaseLogic();

        $sql = 'SELECT * FROM user_master WHERE email = ?';

        // SQL実行
        $result = $db_obj::db_select_arr($sql, $email);

        // データがあればデータが返る　
        if ($result) {
            return $result;
        }

        return false;
    }

    // ログインする
    public static function login_execution($email, $password)
    {
        // メールアドレスが存在するか判定する
        $userData = self::user_exist_check($email);

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

            if (password_verify($password, $db_password)) {

                //ログイン成功の場合 trueを返す
                session_regenerate_id(true);
                $_SESSION['login_user'] = $userData;
                return $_SESSION['login_user'];
            } else {
                return false;
            }
        }
    }
}

// -----------------------------------------------------------------------------------------------------------------

// 投稿を扱うクラス
class PostLogic
{
    // ログインしているかどうか判定する
    public static function login_check()
    {
        // ユーザ情報があればログインしているとみなす return true
        if (isset($_SESSION['login_user'])) {
            $result = $_SESSION['login_user'];
            return $result;
        }

        // セッション情報がない場合はログインしていないとみなす return false;
        return false;
    }

    // テーブル全てのレコードを取得する
    public static function post_acquisition($sql)
    {
        $db_obj = new DatabaseLogic();

        //  SELECTメソッド実行
        $result = $db_obj::db_select($sql);

        // データがあった場合データを返す
        if ($result) {
            return $result;
        }

        return false;
    }
}

// -----------------------------------------------------------------------------------------------------------------

// データベースを扱うクラス
class DatabaseLogic
{
    // SELECTメソッド（パラメータなし）
    public static function db_select($sql)
    {
        try {
            // sql実行
            $stmt = connect()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

            // データを返す
            return $result;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');

            // エラーの場合Falseを返す
            return false;
        }
    }

    // SELECTメソッド（パラメータあり）
    public static function db_select_arr($sql, $arr)
    {
        try {
            // sql実行
            $stmt = connect()->prepare($sql);
            $stmt->execute(array($arr));
            $result = $stmt->fetchAll();

            // データを返す
            return $result;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');

            // エラーの場合Falseを返す
            return false;
        }
    }

    // INSERTメソッド
    public static function db_insert($sql, $arr)
    {
        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($arr);

            // 実行成功の場合
            return true;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');

            // 実行失敗
            return false;
        }
    }

    // UPDATEメソッド
    public static function db_update($sql, $arr)
    {
        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($arr);

            // 更新成功
            return true;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');

            // 更新失敗
            return false;
        }
    }

    // DELETEメソッド
    public static function db_delete($sql, $arr)
    {
        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($arr);

            // 削除完了
            return true;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');

            // 削除失敗
            return false;
        }
    }
}

// -----------------------------------------------------------------------------------------------------------------