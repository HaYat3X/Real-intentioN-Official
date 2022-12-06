<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Register
{
    private string $email = "";

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

        $sql = "INSERT INTO `staff_master`(`name`, `email`, `password`) VALUES (?, ?, ?)";

        $argument = [];
        $argument[] = strval($name);
        $argument[] = strval($email);
        $argument[] = strval(password_hash($password, PASSWORD_DEFAULT));

        $result = $pdo_calc->data_various_kinds($sql, $argument);

        return $result;
    }
}
