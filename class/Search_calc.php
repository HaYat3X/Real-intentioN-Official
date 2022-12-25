<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Search
{
    /**
     * インターン体験記のデータを検索する
     */
    public function intern_experience_search($search_category, $search_keyword)
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `intern_experience_tbl` INNER JOIN `student_mst` ON intern_experience_tbl.user_id = student_mst.student_id WHERE intern_experience_tbl.$search_category LIKE ? ORDER BY intern_experience_tbl.post_id DESC";

        $argument = [];
        $argument[] = '%' . $search_keyword . '%';

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }

    /**
     * ES体験記のデータを検索する
     */
    public function es_experience_search($search_category, $search_keyword)
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `es_experience_tbl` INNER JOIN `student_mst` ON es_experience_tbl.student_id = student_mst.student_id WHERE es_experience_tbl.$search_category LIKE ? ORDER BY es_experience_tbl.post_id DESC";

        $argument = [];
        $argument[] = '%' . $search_keyword . '%';

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }

    /**
     * インターン情報のデータを検索する
     */
    public function intern_information_search($search_category, $search_keyword)
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `intern_information_tbl` INNER JOIN `staff_mst` ON intern_information_tbl.staff_id = staff_mst.staff_id WHERE intern_information_tbl.$search_category LIKE ? ORDER BY intern_information_tbl.post_id DESC";

        $argument = [];
        $argument[] = '%' . $search_keyword . '%';

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }

    /**
     * 会社説明会情報のデータを検索する
     */
    public function briefing_information_search($search_category, $search_keyword)
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `briefing_information_tbl` INNER JOIN `staff_mst` ON briefing_information_tbl.staff_id = staff_mst.staff_id WHERE briefing_information_tbl.$search_category LIKE ? ORDER BY briefing_information_tbl.post_id DESC";

        $argument = [];
        $argument[] = '%' . $search_keyword . '%';

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }
}
