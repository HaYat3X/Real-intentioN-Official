<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Login
{
    private $student_email = "";
    private $student_password = "";
    private $staff_email = "";
    private $staff_password = "";

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
        $sql = 'SELECT * FROM student_mst WHERE email = ?';

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
        if (password_verify($this->student_password, $db_password)) {
            return $login_data_select;
        } else {
            return false;
        }
    }

    /**
     * 職員メールアドレスをプロパティにセットする
     */
    public function staff_set_email($staff_email)
    {
        $this->staff_email = $staff_email;
    }

    /**
     * 職員パスワードをプロパティにセットする
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
