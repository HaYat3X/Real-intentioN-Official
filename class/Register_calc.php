<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Register
{
    private $email = "";
    private $student_email = "";
    private $student_password = "";
    private $staff_email = "";
    private $staff_password = "";

    /**
     * emailプロパティに値をセット
     */
    public function set_email($email)
    {
        $this->email = $email;
    }

    /**
     * 登録済みかどうか判定する 登録済みの場合配列が返る
     */
    public function registered_check($sql)
    {
        $pdo_calc = new Database();

        $argument[] = strval($this->email);
        $result = $pdo_calc->data_select_argument($sql, $argument);

        return $result;
    }

    /**
     * メールアドレスにトークンを送信する (メールアドレス認証のため)
     */
    public function send_token()
    {
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');

        $to = $this->email;
        $subject = "メールアドレス認証トークン";
        $token = rand();
        $message = '認証トークンは' . '"' . $token . '"' . 'です。';
        $headers = "From: hayate.syukatu1@gmail.com";
        mb_send_mail($to, $subject, $message, $headers);

        return $token;
    }

    /**
     * 学生登録データをデータベースに登録する
     */
    public function student_register($name, $email, $password, $course_of_study, $grade_in_school, $attendance_record_number)
    {
        $pdo_calc = new Database();

        $sql = "INSERT INTO `Student_Mst` (`name`, `email`, `password`, `course_of_study`, `grade_in_school`, `status`, `attendance_record_number`) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $argument = [];
        $argument[] = strval($name);
        $argument[] = strval($email);
        $argument[] = strval(password_hash($password, PASSWORD_DEFAULT));
        $argument[] = strval($course_of_study);
        $argument[] = strval($grade_in_school);
        $argument[] = strval('活動中');
        $argument[] = strval($attendance_record_number);

        $result = $pdo_calc->data_various_kinds($sql, $argument);

        return $result;
    }

    /**
     * 職員情報をデータベースに登録する
     */
    public function staff_register($name, $email, $password)
    {
        $pdo_calc = new Database();

        $sql = "INSERT INTO `staff_mst`(`name`, `email`, `password`) VALUES (?, ?, ?)";

        $argument = [];
        $argument[] = strval($name);
        $argument[] = strval($email);
        $argument[] = strval(password_hash($password, PASSWORD_DEFAULT));

        $result = $pdo_calc->data_various_kinds($sql, $argument);

        return $result;
    }

    /**
     * 学生メールアドレスをプロパティにセットする
     */
    public function student_set_email($student_email)
    {
        $this->student_email = $student_email;
    }

    /**
     * 学生パスワードをプロパティにセットする
     */
    public function student_set_password($student_password)
    {
        $this->student_password = $student_password;
    }

    /**
     * 学生ログイン処理をする。
     */
    public function student_login()
    {
        // インスタンス化
        $db_inst = new Database();

        // データが存在するか検証する
        $sql = 'SELECT * FROM Student_Mst WHERE email = ?';

        // パラメータを配列に格納
        $argument = [];
        $argument[] = strval($this->student_email);

        $login_data_select = $db_inst->data_select_argument($sql, $argument);

        if (!$login_data_select) {
            return false;
        }

        // DBのパスワードを取得
        foreach ($login_data_select as $row) {
            $db_password = $row['password'];
        }

        // パスワードの照会
        if (password_verify($this->staff_password, $db_password)) {
            return $login_data_select;
        } else {
            return false;
        }
    }

    /**
     * 学生メールアドレスをプロパティにセットする
     */
    public function staff_set_email($staff_email)
    {
        $this->staff_email = $staff_email;
    }

    /**
     * 学生パスワードをプロパティにセットする
     */
    public function staff_set_password($staff_password)
    {
        $this->staff_password = $staff_password;
    }

    /**
     * 職員ログイン処理をする。
     */
    public function staff_login()
    {
        // インスタンス化
        $db_inst = new Database();

        // データが存在するか検証する
        $sql = 'SELECT * FROM staff_mst WHERE email = ?';

        // パラメータを配列に格納
        $argument = [];
        $argument[] = strval($this->staff_email);

        $login_data_select = $db_inst->data_select_argument($sql, $argument);

        if (!$login_data_select) {
            return false;
        }

        // DBのパスワードを取得
        foreach ($login_data_select as $row) {
            $db_password = $row['password'];
        }

        // パスワードの照会
        if (password_verify($this->staff_password, $db_password)) {
            return $login_data_select;
        } else {
            return false;
        }
    }
}
