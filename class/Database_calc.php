<?php

class Database
{
    /**
     * データベースに接続する
     */
    public function db_connect()
    {
        // 接続するDBを設定
        $dsn = 'mysql:dbname=Real intentioN;host=localhost';
        $user = 'root';
        $password = 'root';

        // DBに接続する
        try {
            $pdo = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
            exit();
        }

        return $pdo;
    }

    /**
     * データベースからデータを取得する　（パラメータなし）
     */
    public function data_select($sql)
    {
        try {
            $pdo = $this->db_connect();

            // SQL発行
            $stmt = $pdo->prepare($sql);

            // SQL実行
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 返り値を変数に格納
            return $result;
        } catch (\Exception $e) {
            echo $e;
            return false;
        }
    }

    /**
     * データベースからデータを取得する　（パラメータあり）
     */
    public function data_select_argument($sql, $argument)
    {
        try {
            $pdo = $this->db_connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($argument);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Exception $e) {
            echo $e;
            return false;
        }
    }

    /**
     *  SQL文 INSERT UPDATE DELETEを実行
     */
    public function data_various_kinds($sql, $argument)
    {
        try {
            $pdo = $this->db_connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($argument);
            return true;
        } catch (\Exception $e) {
            echo $e;
            return false;
        }
    }

    /**
     * 取得したデータの件数をカウントする
     */
    public function data_select_count($sql, $argument)
    {
        try {
            $pdo = $this->db_connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($argument);
            $result = $stmt->rowCount();
            return $result;
        } catch (\Exception $e) {
            echo $e;
            return false;
        }
    }
}
