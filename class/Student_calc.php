<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Student
{
    /**
     * サービスに登録している学生情報を取得する
     */
    public function student_date()
    {
        // インスタンス化
        $db_inst = new Database();

        $sql = "SELECT * FROM `student_mst` ORDER BY `student_id` DESC;";

        $result = $db_inst->data_select($sql);

        return $result;
    }

    /**
     * サービスに登録している学生情報を検索する
     */
    public function student_search($search_category, $search_keyword)
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `student_mst` WHERE student_mst.$search_category LIKE ? ORDER BY `student_id` DESC";

        $argument = [];
        $argument[] = '%' . $search_keyword . '%';

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }
}
