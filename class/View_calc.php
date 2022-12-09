<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class View
{
    /**
     * インターン体験記のテーブル全レコード取得
     */
    public function intern_experience_data()
    {
        $db_calc = new Database();

        $sql = 'SELECT * FROM `intern_experience_tbl` INNER JOIN `student_mst` ON intern_experience_tbl.user_id = student_mst.student_id ORDER BY intern_experience_tbl.post_id DESC';

        $result = $db_calc->data_select($sql);

        return $result;
    }
}
