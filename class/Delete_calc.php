<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Delete
{
    /**
     * インターン体験記のデータを削除する
     */
    public function intern_experience_delete($post_id)
    {
        $db_calc = new Database();

        // SQL発行
        $sql = "DELETE FROM `intern_experience_tbl` WHERE post_id = ?";

        // パラメータを配列に格納
        $argument = [];
        $argument[] = strval($post_id);

        // 削除処理実行
        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }

    /**
     * ES体験記のデータを削除する
     */
    public function es_experience_delete($post_id)
    {
        $db_calc = new Database();

        $sql = "DELETE FROM `es_experience_tbl` WHERE post_id = ?";

        $argument = [];
        $argument[] = strval($post_id);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }

    /**
     * インターンシップ情報のデータを削除する
     */
    public function intern_information_delete($post_id)
    {
        $db_calc = new Database();

        $sql = "DELETE FROM `intern_information_tbl` WHERE post_id = ?";

        $argument = [];
        $argument[] = strval($post_id);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }

    /**
     * 会社説明会情報のデータを削除する
     */
    public function briefing_information_delete($post_id)
    {
        $db_calc = new Database();

        $sql = "DELETE FROM `briefing_information_tbl` WHERE post_id = ?";

        $argument = [];
        $argument[] = strval($post_id);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }
}
