<?php

// DB接続ファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/function/connect_db.php';

// データベースロジッククラス
class DatabaseLogic
{
    // SELECT（引数あり）
    public static function databaseSelect($sql, $data)
    {
        try {
            // sql実行
            $stmt = connect()->prepare($sql);
            $stmt->execute(array($data));
            $result = $stmt->fetchAll();

            // データを返す
            return $result;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');
            return false;
        }
    }

    // SELECT（引数なし）
    public static function databaseSelect2($sql)
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
            return false;
        }
    }

    // INSERT　
    public static function databaseInsert($sql, $data)
    {
        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (\Exception $e) {
            echo $e; // エラーを出力
            error_log($e, 3, '../error.log'); //ログを出力
            return false;
        }
    }

    // UPDATE
    public static function databaseUpdate($sql, $data)
    {
        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (\Exception $e) {
            echo $e; // エラーを出力
            error_log($e, 3, '../error.log'); //ログを出力
            return false;
        }
    }

    // DELETE
    public static function databaseDelete($sql, $data)
    {
        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (\Exception $e) {
            echo $e; // エラーを出力
            error_log($e, 3, '../error.log'); //ログを出力
            return false;
        }
    }
}