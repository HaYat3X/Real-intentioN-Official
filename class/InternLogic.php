<?php

// DB接続ファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/function/connect_db.php';

class InternLogic
{
    // ログインしているかどうか判定する
    public static function loginCheck()
    {
        // ユーザ情報があればログインしているとみなす return true
        if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0) {
            $result = $_SESSION['login_user'];
            // $result = true;
            return $result;
        }

        // セッション情報がない場合はログインしていないとみなす return false;
        return false;
    }

    // インターンテーブルのデータを取得する
    public static function selectInternDate()
    {
        // user情報もまとめて取得 join句を利用
        $sql = 'SELECT * FROM user_master INNER JOIN intern_table ON user_master.id = intern_table.user_id ORDER BY intern_table.id DESC';

        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute();

            // $resultに配列格納
            $result = $stmt->fetchAll();
            return $result;
        } catch (\Exception $e) {
            echo $e; // エラーを出力
            error_log($e, 3, '../error.log'); //ログを出力
            return false;
        }
    }

    // インターンテーブルに値を登録する
    public static function insertInternDate($formDate)
    {
        // sql発行
        $sql = 'INSERT INTO `intern_table`(`user_id`, `company`, `format`, `content`, `question`, `answer`, `ster`, `field`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

        try {
            $stmt = connect()->prepare($sql);

            // insertするデータを配列に格納
            $arr = [];
            $arr[] = $formDate['user_id'];
            $arr[] = $formDate['company'];
            $arr[] = $formDate['format'];
            $arr[] = $formDate['content'];
            $arr[] = $formDate['question'];
            $arr[] = $formDate['answer'];
            $arr[] = $formDate['ster'];
            $arr[] = $formDate['field'];
            
            // sql実行
            $stmt->execute($arr);

            $result = true;
            return $result;
        } catch (\Exception $e) {
            echo $e; // エラーを出力
            error_log($e, 3, '../error.log'); //ログを出力
            $result = false;
            return $result;
        }
    }
}
