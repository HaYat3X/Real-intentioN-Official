<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Profile
{
    /**
     * 学生情報を取得する
     */
    public function student_data($user_id)
    {
        // インスタンス化
        $db_inst = new Database();

        $sql = "SELECT * FROM student_mst WHERE student_id = ?";

        // パラメータを配列に格納
        $argument = [];
        $argument[] = strval($user_id);

        $result = $db_inst->data_select_argument($sql, $argument);

        return $result;
    }
}
