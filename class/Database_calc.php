<?php

class Database
{
    //DB接続定数
    const DB_NAME = 'Real intentioN';
    const HOST = 'localhost';
    const UTF = 'utf8';
    const USER = 'root';
    const PASS = 'root';

    /**
     * データベースに接続する
     * @param 
     * @return $pdo
     */
    public function db_connect()
    {
        $dsn = "mysql:dbname=" . self::DB_NAME . ";host=" . self::HOST . ";charset=" . self::UTF;
        $user = self::USER;
        $pass = self::PASS;

        try {
            $pdo = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . SELF::UTF));
        } catch (Exception $e) {
            echo 'DB接続に失敗しました。' . $e->getMessage();
            exit();
        }

        //エラーを表示してくれる。
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        return $pdo;
    }

    /**
     * データベースからデータを取得する　（パラメータなし）
     * @param 
     * @return $pdo
     */
    public function data_select($sql)
    {
        try {
            // sql実行
            $pdo = $this->db_connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // データを返す
            return $result;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');

            // エラーの場合Falseを返す
            return false;
        }
    }

    /**
     * データベースからデータを取得する　（パラメータあり）
     * @param $argument
     * @return $pdo
     */
    public function data_select_argument($sql, $argument)
    {
        try {
            // sql実行
            $pdo = $this->db_connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($argument);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // データを返す
            return $result;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');

            // エラーの場合Falseを返す
            return false;
        }
    }

    // INSERT UPDATE DELETE
    public function data_various_kinds($sql, $argument)
    {
        try {
            // sql実行
            $pdo = $this->db_connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($argument);
            return true;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');

            // エラーの場合Falseを返す
            return false;
        }
    }

    // セレクトした回数を判定する
    public function data_select_count($sql, $argument)
    {
        try {
            // sql実行
            $pdo = $this->db_connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($argument);
            $result = $stmt->rowCount();

            // データを返す
            return $result;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');

            // エラーの場合Falseを返す
            return false;
        }
    }
}
