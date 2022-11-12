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
        $result = $db_obj::db_select_arr2($sql, $email);

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

    // メールアドレスに認証用のトークンを送信する
    public static function push_token($email)
    {
        $send = $email;
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
        $to = $send;
        $subject = "メールアドレス認証トークン";
        $token = rand();
        $message = '認証トークンは' . '"' . $token . '"' . 'です。';
        $headers = "From: hayate.syukatu1@gmail.com";
        mb_send_mail($to, $subject, $message, $headers);
        return $token;
    }

    // ユーザ登録する
    public static function create_user($sql, $arr)
    {
        $db_obj = new DatabaseLogic();

        $result = $db_obj::db_insert($sql, $arr);

        if (!$result) {
            return false;
        }

        return true;
    }
}


// 職員用のクラス
class StaffLogic
{
    // メールアドレスが存在するか確認する
    public static function staff_exist_check($email)
    {
        $db_obj = new DatabaseLogic();

        $sql = 'SELECT * FROM staff_master WHERE email = ?';

        // SQL実行
        $result = $db_obj::db_select_arr2($sql, $email);

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
        $userData = self::staff_exist_check($email);

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
                $_SESSION['login_staff'] = $userData;
                return $_SESSION['login_staff'];
            } else {
                return false;
            }
        }
    }

    // ユーザ登録する
    public static function create_staff_user($sql, $arr)
    {
        $db_obj = new DatabaseLogic();

        $result = $db_obj::db_insert($sql, $arr);

        if (!$result) {
            return false;
        }

        return true;
    }
}

// ---------------------------------------------------------------------------------------------------------------

// 投稿を扱うクラス
class PostLogic
{
    // ログインしているかどうか判定する（学生）
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

    // ログインしているかどうか確認する（職員）
    public static function login_check_staff()
    {
        // ユーザ情報があればログインしているとみなす return true
        if (isset($_SESSION['login_staff'])) {
            $result = $_SESSION['login_staff'];
            return $result;
        }

        // セッション情報がない場合はログインしていないとみなす return false;
        return false;
    }

    // テーブル全てのレコードを取得する
    public static function post_acquisition($sql)
    {
        $db_obj = new DatabaseLogic();

        // SELECTメソッド実行
        $result = $db_obj::db_select($sql);

        // データがあった場合データを返す
        if ($result) {
            return $result;
        }

        return false;
    }

    // 新規投稿するメソッド
    public static function post_submission($sql, $bind)
    {
        $db_obj = new DatabaseLogic();

        // INSERTメソッド実行
        $result = $db_obj::db_insert($sql, $bind);

        // データがあった場合データを返す
        if ($result) {
            return $result;
        }

        return false;
    }

    // パラメータの条件で取得する
    public static function post_one_acquisition($sql, $bind)
    {
        $db_obj = new DatabaseLogic();

        // SELECTパラメータありメソッド実行
        $result = $db_obj::db_select_arr($sql, $bind);

        // データがあった場合データを返す
        if ($result) {
            return $result;
        }

        return false;
    }

    // データを更新するメソッドを実行
    public static function post_update($sql, $bind)
    {
        $db_obj = new DatabaseLogic();

        // UPDATEパラメータありメソッド実行
        $result = $db_obj::db_update($sql, $bind);

        // データがあった場合データを返す
        if ($result) {
            return $result;
        }

        return false;
    }

    // 投稿を削除するメソッドを実行
    public static function post_delete($sql, $bind)
    {
        $db_obj = new DatabaseLogic();

        // UPDATEパラメータありメソッド実行
        $result = $db_obj::db_delete($sql, $bind);

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

    // SELECTメソッド（パラメータあり）　パラメータがintの場合
    public static function db_select_arr($sql, $arr)
    {
        try {
            // sql実行
            $stmt = connect()->prepare($sql);
            $stmt->execute($arr);
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

       // SELECTメソッド（パラメータあり）　パラメータが文字列の場合
       public static function db_select_arr2($sql, $arr)
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

// ---------------------------------------------------------------------------------------------------------------