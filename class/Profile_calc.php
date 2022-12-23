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

    /**
     * 学生情報を更新する
     */
    public function student_profile_update($user_id, $icon_path, $name, $department, $school_year, $number, $doc, $status)
    {
        // インスタンス化
        $db_inst = new Database();

        $sql = "UPDATE `Student_Mst` SET `name`=?, `course_of_study`=?, `grade_in_school`=?, `status`=?, `attendance_record_number`=?, `icon`=?, `doc`=? WHERE student_id = ?";

        // パラメータを配列に格納
        $argument = [];
        $argument[] = strval($name);
        $argument[] = strval($department);
        $argument[] = strval($school_year);
        $argument[] = strval($status);
        $argument[] = strval($number);
        $argument[] = strval($icon_path);
        $argument[] = strval($doc);
        $argument[] = strval($user_id);

        $result = $db_inst->data_various_kinds($sql, $argument);

        return $result;
    }
}
