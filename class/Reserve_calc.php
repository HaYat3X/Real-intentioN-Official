<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Reserve
{
    /**
     * インターンシップ情報に予約ができるか判定する
     */
    public function intern_information_reserve_check($post_id, $student_id)
    {
        $db_calc = new Database();

        // 投稿にいいねできるか確認する。
        $sql = 'SELECT * FROM intern_information_reserve_tbl WHERE reserve_post_id = ? AND student_id = ?';

        $argument = [];
        $argument[] = strval($post_id);
        $argument[] = strval($student_id);

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }

    /**
     * インターンシップ情報各投稿の予約数を取得する
     */
    public function intern_information_reserve_count($post_id)
    {
        $db_calc = new Database();

        $sql = 'SELECT * FROM intern_information_reserve_tbl WHERE reserve_post_id = ?';

        $argument[] = strval($post_id);

        $result = $db_calc->data_select_count($sql, $argument);

        return $result;
    }

    /**
     * インターンシップ情報に予約する
     */
    public function intern_information_reserve($post_id, $student_id)
    {
        $db_calc = new Database();

        $sql = "INSERT INTO `intern_information_reserve_tbl` (`reserve_post_id`, `student_id`) VALUES (?, ?)";

        $argument = [];
        $argument[] = strval($post_id);
        $argument[] = strval($student_id);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }

    /**
     * インターンシップ情報の予約を解除する
     */
    public function intern_information_reserve_delete($post_id, $student_id)
    {
        $db_calc = new Database();
        
        $sql = "DELETE FROM `intern_information_reserve_tbl` WHERE reserve_post_id = ? AND student_id = ?";

        $argument = [];
        $argument[] = strval($post_id);
        $argument[] = strval($student_id);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }
}
