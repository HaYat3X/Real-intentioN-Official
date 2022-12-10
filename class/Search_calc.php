<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Search
{
    public function intern_experience_search($search_category, $search_keyword)
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `intern_experience_tbl` INNER JOIN `student_mst` ON intern_experience_tbl.user_id = student_mst.student_id WHERE intern_experience_tbl.$search_category LIKE ? ORDER BY intern_experience_tbl.post_id DESC";

        $argument = [];
        $argument[] = '%' . $search_keyword . '%';

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }
}
