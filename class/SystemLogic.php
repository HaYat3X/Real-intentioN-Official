<?php

class StudentLogics
{
    /**
     * メールアドレスにトークンを送信する (メールアドレス認証のため)
     * @param \src\Userview\register\provisional_registration.php $email, $token
     * @return token
     * @return false
     */
    public function push_token($email)
    {
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
        $to = $email;
        $subject = "メールアドレス認証トークン";
        $token = rand();
        $message = '認証トークンは' . '"' . $token . '"' . 'です。';
        $headers = "From: hayate.syukatu1@gmail.com";
        mb_send_mail($to, $subject, $message, $headers);
        return $token;
    }
}

class ArrayParamsLogics
{
    /**
     * 学生新規登録メールアドレス仮登録時、sqlにバインドするデータ
     * @param $email
     * @return $argument
     */
    public function student_register_provisional_registration_prm($email)
    {
        $argument = [];
        $argument[] = strval($email);
        return $argument;
    }
}

class DataValidationLogics
{
    private $errorMsg = "";

    /**
     * 学生新規登録メールアドレス仮登録時のバリデーション
     * @param $email
     * @return true
     * @return false
     */
    public function student_register_provisional_registration_val($email)
    {
        // 未入力のチェック
        if ($email == "") {
            $this->errorMsg = "メールアドレスを入力してください。";
            return false;
        }

        // 正規表現で神戸電子以外のメールアドレスは登録できないようにする
        if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@st.kobedenshi.ac.jp/", $email)) {
            $this->errorMsg = '@st.kobedenshi.ac.jpのメールアドレスを入力してください。';
            return false;
        }

        //入力値の型のチェック
        if (!is_string($email)) {
            $this->errorMsg = "メールアドレスが不正です。f";
            return false;
        }

        // バリデーションに引っかからない場合True
        return true;
    }


    /**
     * バリデーションにj引っ掛かった場合のエラーメッセージを表示
     * @param 
     * @return errorMsg
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
}

class DatabaseLogics
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

        // return $pdo
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
}
