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
     * @return object
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
     * @param $sql
     * @return array
     */
    public function data_select($sql)
    {
        try {
            // sql実行
            $pdo = $this->db_connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');
            return false;
        }
    }

    /**
     * データベースからデータを取得する　（パラメータあり）
     * @param $sql $argument
     * @return array
     */
    public function data_select_argument($sql, $argument)
    {
        try {
            // sql実行
            $pdo = $this->db_connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($argument);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');
            return false;
        }
    }

    /**
     *  SQL文 INSERT UPDATE DELETEを実行
     * @param $sql $argument
     * @return bool
     */
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
            return false;
        }
    }

    /**
     * 取得したデータの件数をカウントする
     * @param $sql $argument
     * @return array
     */
    public function data_select_count($sql, $argument)
    {
        try {
            // sql実行
            $pdo = $this->db_connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($argument);
            $result = $stmt->rowCount();
            return $result;
        } catch (\Exception $e) {
            echo $e;
            error_log($e, 3, '../error.log');
            return false;
        }
    }
}
