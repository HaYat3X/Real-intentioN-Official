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

        $sql = 'SELECT i.id, i.user_id, i.company, i.format, i.content, i.question, i.answer, i.ster, i.field, u.name, u.department, u.school_year FROM intern_table i, user_master u WHERE i.user_id = u.id ORDER BY id DESC';

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

    // 編集、削除する対象データを取得する
    public static function selectInternOneDate($post_id)
    {
        $obj = new DatabaseLogic;

        // sql発行 ANDで複数条件指定
        $sql = 'SELECT i.id, i.user_id, i.company, i.format, i.content, i.question, i.answer, i.ster, i.field, u.name, u.department, u.school_year FROM intern_table i, user_master u WHERE i.user_id = u.id AND i.id = ? ORDER BY i.id DESC';

        // SELECTメソッド
        $result = $obj::databaseSelect($sql, $post_id);

        return $result;
    }

    // 投稿を編集する
    public static function updateInternDate($formData)
    {
        $obj = new DatabaseLogic;

        // sql発行
        $sql = 'UPDATE `intern_table` SET `user_id`=?, `company`=?, `format`=?, `content`=?, `question`=?,`answer`=?, `ster`=?, `field`=? WHERE id=?';

        // updateするデータを配列に格納
        $arr = [];
        $arr[] = $formData['user_id'];
        $arr[] = $formData['company'];
        $arr[] = $formData['format'];
        $arr[] = $formData['content'];
        $arr[] = $formData['question'];
        $arr[] = $formData['answer'];
        $arr[] = $formData['ster'];
        $arr[] = $formData['field'];
        $arr[] = $formData['post_id'];


        // UPDATEメソッド実行
        $result = $obj::databaseUpdate($sql, $arr);

        if (!$result) {
            return false;
        }

        return true;
    }

    // 投稿を削除する
    public static function deleteInternDate($post_id)
    {
        $obj = new DatabaseLogic;

        $sql = 'DELETE FROM `intern_table` WHERE id = ?';

        // int型に変換
        $arr = [];
        $arr[] =  $post_id;

        $result = $obj::databaseDelete($sql, $arr);

        return $result;
    }

    // コメントを取得する
    public static function selectInternCommentDate($post_id)
    {
        $obj = new DatabaseLogic;

        // sql発行 ANDで複数条件指定
        $sql = 'SELECT r.id, r.post_id, r.user_id, r.comment, u.name, u.department, u.school_year FROM intern_reply_table r, user_master u WHERE r.user_id = u.id AND r.post_id = ? ORDER BY r.id DESC';

        // SELECTメソッド
        $result = $obj::databaseSelect($sql, $post_id);

        return $result;
    }

    // コメントを投稿する
    public static function insertInternCommentDate($post, $userId)
    {
        $obj = new DatabaseLogic;

        $sql = 'INSERT INTO `intern_reply_table`(`post_id`, `user_id`, `comment`) VALUES (?, ?, ?)';

        $arr = [];
        $arr[] = $post['post_id'];
        $arr[] = (string)$userId;
        $arr[] = $post['content'];

        $result = $obj::databaseInsert($sql, $arr);
        return $result;
    }
}
