<?php

// データベースロジックファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/class/DatabaseLogic.php';

class InternLogic
{
    // ログインしているかどうか判定する
    public static function loginCheck()
    {
        // ユーザ情報があればログインしているとみなす return true
        if (isset($_SESSION['login_user'])) {
            $result = $_SESSION['login_user'];
            return $result;
        }

        // セッション情報がない場合はログインしていないとみなす return false;
        return false;
    }

    // インターンテーブルのデータを取得する
    public static function selectInternDate()
    {
        $obj = new DatabaseLogic;

        // user情報もまとめて取得 join句を利用
        $sql = 'SELECT * FROM intern_table INNER JOIN user_master ON user_master.id = intern_table.user_id';

        // SELECTメソッド
        $result = $obj::databaseSelect2($sql);

        return $result;
    }

    // インターンテーブルに値を登録する
    public static function insertInternDate($formDate)
    {
        $obj = new DatabaseLogic;

        // sql発行
        $sql = 'INSERT INTO `intern_table`(`user_id`, `company`, `format`, `content`, `question`, `answer`, `ster`, `field`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

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

        // INSERTメソッド実行
        $result = $obj::databaseInsert($sql, $arr);

        if (!$result) {
            return false;
        }

        return true;
    }
}
