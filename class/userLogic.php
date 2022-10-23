<?php

// DB接続ファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/function/connect_db.php';

// UserLogicクラス
class UserLogic
{

    // ユーザが登録済みかどうか判定する
    public static function checkUser($email)
    {
        // sql発行
        $sql = 'SELECT * FROM user_master WHERE email = ?';

        // ユーザデータを配列に入れる
        $arr = [];
        $arr[] = $email;

        try {
            // sql実行
            $stmt = connect()->prepare($sql);
            $stmt->execute($arr);
            $bind = $stmt->fetch();

            if ($bind) {
                // 登録NG
                return 'NG';
            } else {
                // 登録OK
                $result = true;
                return 'OK';
            }
        } catch (\Exception $e) {
            echo $e; // エラーを出力
            error_log($e, 3, '../error.log'); //ログを出力
            return 'NG';
        }
    }

    // メールアドレス認証トークンの送信
    public static function pushToken($email)
    {
        // 登録完了メールの送信
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

    // ユーザ新規登録をする
    public static function createUser($userDate)
    {
        $result = false;

        $sql = 'INSERT INTO `user_master`(`name`, `email`, `password`, `department`, `school_year`, `number`) VALUES (?, ?, ?, ?, ?, ?)';

        $arr = [];
        $arr[] = $userDate['name'];
        $arr[] = $userDate['email'];

        // パスワードはハッシュ化する
        $arr[] = password_hash($userDate['password'], PASSWORD_DEFAULT);
        $arr[] = $userDate['department'];
        $arr[] = $userDate['school_year'];
        $arr[] = $userDate['number'];

        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($arr);
            $result = true;
            return $result;
        } catch (\Exception $e) {
            echo $e; // エラーを出力
            error_log($e, 3, '../error.log'); //ログを出力
            return $result;
        }
    }

    // ログイン処理
    public static function login($email, $password)
    {
        // ユーザをemailから検索して取得
        $user = self::getUserByEmail($email);

        // ユーザが存在しなかった場合 falseを返す
        if (!$user) {
            $result = false;
            return $result;
        }

        // ユーザが存在した場青 パスワードの比較
        if (password_verify($password, $user['password'])) {
            //ログイン成功の場合 trueを返す
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        } else {
            // パスワードが一致しない場合 falseを返す
            $result = false;
            return $result;
        }
    }

    // ユーザが存在するか判定する関数
    public static function getUserByEmail($email)
    {
        $sql = 'SELECT * FROM `user_master` WHERE email = ?';

        // emailを配列に入れる
        $arr = [];
        $arr[] = $email;

        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($arr);
            // SQLの結果を返す
            $user = $stmt->fetch();
            return $user;
        } catch (\Exception $e) {
            echo $e; // エラーを出力
            error_log($e, 3, '../error.log'); //ログを出力
            return false;
        }
    }

    // ログインしているかどうか判定する
    // public static function loginCheck()
    // {
    //     // ユーザ情報があればログインしているとみなす return true
    //     if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0) {
    //         $result = true;
    //         return $result;
    //     }

    //     // セッション情報がない場合はログインしていないとみなす return false;
    //     return false;
    // }
}
