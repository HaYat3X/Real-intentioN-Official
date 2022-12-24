<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class View
{
    /**
     * インターン体験記のテーブル全レコード取得
     */
    public function intern_experience_data($start)
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `intern_experience_tbl` INNER JOIN `student_mst` ON intern_experience_tbl.user_id = student_mst.student_id ORDER BY intern_experience_tbl.post_id DESC LIMIT {$start}, 10";

        $result = $db_calc->data_select($sql);

        return $result;
    }

    /**
     * インターン体験記のテーブルのレコードの数を取得
     */
    public function intern_experience_data_val()
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `intern_experience_tbl` INNER JOIN `student_mst` ON intern_experience_tbl.user_id = student_mst.student_id ORDER BY intern_experience_tbl.post_id DESC";

        $argument = [];

        $result = $db_calc->data_select_count($sql, $argument);

        return $result;
    }

    /**
     * インターン体験記の投稿一件を取得
     */
    public function intern_experience_data_one($post_id)
    {
        $db_calc = new Database();

        $sql = 'SELECT * FROM `intern_experience_tbl` INNER JOIN `student_mst` ON intern_experience_tbl.user_id = student_mst.student_id AND intern_experience_tbl.post_id = ?';

        $argument = [];
        $argument[] = $post_id;

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }

    /**
     * ES体験記のテーブル全レコード取得
     */
    public function es_experience_data($start)
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `es_experience_tbl` INNER JOIN `student_mst` ON es_experience_tbl.student_id = student_mst.student_id ORDER BY es_experience_tbl.post_id DESC LIMIT {$start}, 10";

        $result = $db_calc->data_select($sql);

        return $result;
    }

    /**
     * ES体験記のテーブルのレコードの数を取得
     */
    public function es_experience_data_val()
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `es_experience_tbl` INNER JOIN `student_mst` ON es_experience_tbl.student_id = student_mst.student_id ORDER BY es_experience_tbl.post_id DESC";

        $argument = [];

        $result = $db_calc->data_select_count($sql, $argument);

        return $result;
    }

    /**
     * ES体験記の投稿一件を取得
     */
    public function es_experience_data_one($post_id)
    {
        $db_calc = new Database();

        $sql = 'SELECT * FROM `es_experience_tbl` INNER JOIN `student_mst` ON es_experience_tbl.student_id = student_mst.student_id AND es_experience_tbl.post_id = ?';

        $argument = [];
        $argument[] = $post_id;

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }

    /**
     * インターンシップ情報のテーブル全レコード取得
     */
    public function intern_information_data($start)
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `intern_information_tbl` INNER JOIN `staff_mst` ON intern_information_tbl.staff_id = staff_mst.staff_id ORDER BY intern_information_tbl.post_id DESC LIMIT {$start}, 10";

        $result = $db_calc->data_select($sql);

        return $result;
    }

    /**
     * インターンシップ情報のテーブルのレコードの数を取得
     */
    public function intern_information_data_val()
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `intern_information_tbl` INNER JOIN `staff_mst` ON intern_information_tbl.staff_id = staff_mst.staff_id ORDER BY intern_information_tbl.post_id DESC";

        $argument = [];

        $result = $db_calc->data_select_count($sql, $argument);

        return $result;
    }

    /**
     * インターンシップ情報を特定の一件だけ取得
     */
    public function intern_information_data_one($post_id)
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `intern_information_tbl` INNER JOIN `staff_mst` ON intern_information_tbl.staff_id = staff_mst.staff_id AND intern_information_tbl.post_id = ?";

        $argument = [];
        $argument[] = $post_id;

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }

    /**
     * インターンシップ情報のテーブル全レコード取得
     */
    public function briefing_information_data($start)
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `briefing_information_tbl` INNER JOIN `staff_mst` ON 
        briefing_information_tbl.staff_id = staff_mst.staff_id ORDER BY briefing_information_tbl.post_id DESC LIMIT {$start}, 10";

        $result = $db_calc->data_select($sql);

        return $result;
    }

    /**
     * インターンシップ情報のテーブルのレコードの数を取得
     */
    public function briefing_information_data_val()
    {
        $db_calc = new Database();

        $sql = "SELECT * FROM `briefing_information_tbl` INNER JOIN `staff_mst` ON 
        briefing_information_tbl.staff_id = staff_mst.staff_id ORDER BY briefing_information_tbl.post_id";

        $argument = [];

        $result = $db_calc->data_select_count($sql, $argument);

        return $result;
    }
}
