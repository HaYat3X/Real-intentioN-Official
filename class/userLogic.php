<?php

// DB接続ファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/function/connect_db.php';

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
}
