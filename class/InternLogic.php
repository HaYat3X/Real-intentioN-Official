<?php

// DB接続ファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/function/connect_db.php';

// UserLogicクラス
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
        $sql = 'SELECT * FROM user_master INNER JOIN intern_table ON  user_master.id = intern_table.user_id ORDER BY intern_table.id DESC;';
        $stmt = connect()->prepare($sql);
        $stmt->execute();

        // $resultに配列格納
        $result = $stmt->fetchAll();
        return $result;
    }


}
