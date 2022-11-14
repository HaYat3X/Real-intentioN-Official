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

    /**
     * 学生がログインしているのか判定する
     * @param 
     * @return $userId
     * @return false
     */
    public static function get_student_id()
    {
        // ユーザ情報があればログインしているとみなす return true
        if (isset($_SESSION['login_student'])) {
            $result = $_SESSION['login_student'];

            foreach ($result as $row) {
                $userId = $row['student_id'];
                return $userId;
            }
        }

        // セッション情報がない場合はログインしていないとみなす return false;
        return false;
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

    /**
     * 学生新規登録メールアドレス仮登録時、sqlにバインドするデータ
     * @param $email
     * @return $argument
     */
    public function student_register_full_registration_prm($name, $email, $password, $department, $school_year, $number)
    {
        $argument = [];
        $argument[] = strval($name);
        $argument[] = strval($email);
        $argument[] = strval(password_hash($password, PASSWORD_DEFAULT));
        $argument[] = strval($department);
        $argument[] = strval($school_year);
        $argument[] = strval($number);
        $argument[] = strval('活動中');
        return $argument;
    }

    /**
     * 学生ログイン時、SQLにバインドするパラメータ
     * @param $email
     * @return $argument
     */
    public function student_login_email_prm($email)
    {
        $argument = [];
        $argument[] = strval($email);
        return $argument;
    }

    /**
     * コメント通知数を取得時にバインドするパラメータ
     * @param $userId
     * @return $argument
     */
    public function student_view_notice_prm($userId)
    {
        $argument = [];
        $argument[] = intval($userId);
        $argument[] = intval($userId);
        $argument[] = intval('0');
        return $argument;
    }

    /**
     * インターン体験記を投稿する際にバインドするパラメータ
     * @param $userId
     * @return $argument
     */
    public function student_post_prm($userId, $company, $format, $content, $question, $answer, $ster, $field)
    {
        $argument = [];
        $argument[] = intval($userId);
        $argument[] = strval($company);
        $argument[] = strval($format);
        $argument[] = strval($content);
        $argument[] = strval($question);
        $argument[] = strval($answer);
        $argument[] = strval($ster);
        $argument[] = strval($field);
        return $argument;
    }

    /**
     * 投稿を一件取得する時のパラメータ
     * @param $post_id
     * @return $argument
     */
    public function student_post_one_prm($post_id)
    {
        $argument = [];
        $argument[] = intval($post_id);
        return $argument;
    }

    /**
     * 投稿を更新する際にバインドするパラメータ
     * @param $post_id
     * @return $argument
     */
    public function student_post_update_prm($userId, $company, $format, $content, $question, $answer, $ster, $field, $post_id)
    {
        $argument = [];
        $argument[] = intval($userId);
        $argument[] = strval($company);
        $argument[] = strval($format);
        $argument[] = strval($content);
        $argument[] = strval($question);
        $argument[] = strval($answer);
        $argument[] = strval($ster);
        $argument[] = strval($field);
        $argument[] = intval($post_id);
        return $argument;
    }

    /**
     * コメント投稿時にバインドするパラメータ
     * @param $post_id
     * @return $argument
     */
    public function student_comment_post_prm($post_id, $post_user_id, $user_id, $comment, $read)
    {
        $argument = [];
        $argument[] = strval($post_id);
        $argument[] = strval($post_user_id);
        $argument[] = strval($user_id);
        $argument[] = strval($comment);
        $argument[] = strval($read);
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

        // バリデーションに引っかからない場合True
        return true;
    }

    /**
     * 学生新規登録トークン入力時のバリデーション
     * @param $token
     * @return true
     * @return false
     */
    public function student_register_auth_email_val($token)
    {
        // 未入力のチェック
        if ($token == "") {
            $this->errorMsg = "トークンを入力してください。";
            return false;
        }

        // バリデーションに引っかからない場合True
        return true;
    }

    /**
     * 学生新規登録学生情報入力時のバリデーション
     * @param $name, $password, $department, $school_yare, $number
     * @return true
     * @return false
     */
    public function student_register_full_registration_val($name, $password, $department, $school_year, $number)
    {
        // 未入力のチェック
        if ($name == "") {
            $this->errorMsg = "ニックネームを入力してください。";
            return false;
        }

        if ($department === "-- 選択してください --") {
            $this->errorMsg = "学科情報を選択してください。";
            return false;
        }

        if ($school_year == "-- 選択してください --") {
            $this->errorMsg = "学年情報を選択してください。";
            return false;
        }

        if ($number == "") {
            $this->errorMsg = "学籍番号を入力してください。";
            return false;
        }

        if ($password == "") {
            $this->errorMsg = "パスワードを入力してください。";
            return false;
        }

        // パスワードの値が8文字以下の場合エラーを出す
        if (!preg_match("/^[0-9A-Za-z]{8,100}$/i", $password)) {
            $this->errorMsg = 'パスワードは8文字で作成してください。';
        }

        return true;
    }

    /**
     * 学生ログイン時のバリデーション
     * @param $email, $password
     * @return true
     * @return false
     */
    public function student_login_val($email, $password)
    {
        // 未入力のチェック
        if ($email == "") {
            $this->errorMsg = "メールアドレスを入力してください。";
            return false;
        }

        if ($password == "") {
            $this->errorMsg = "パスワードを入力してください。";
            return false;
        }

        return true;
    }

    /**
     * 学生ログイン時のバリデーション
     * @param $email, $password
     * @return true
     * @return false
     */
    public function student_post_val($company, $content, $format, $field, $answer, $ster)
    {
        // 未入力のチェック
        if ($company == "") {
            $this->errorMsg = "企業名を入力してください。";
            return false;
        }

        if ($content == "") {
            $this->errorMsg = "体験内容を入力してください。";
            return false;
        }

        if ($format == "-- 選択してください --") {
            $this->errorMsg = "参加形式を選択してください。";
            return false;
        }

        if ($field == "-- 選択してください --") {
            $this->errorMsg = "参加分野を選択してください。";
            return false;
        }

        if ($answer == "") {
            $this->errorMsg = "質問に回答してください。";
            return false;
        }

        if ($ster == "-- 選択してください --") {
            $this->errorMsg = "総合評価を選択してください。";
            return false;
        }

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
