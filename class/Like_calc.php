<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Like
{
    private $post_id = "";
    private $student_id = "";

    /**
     * プロパティに値をセット
     */
    public function set_post_id($post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * プロパティに値をセット
     */
    public function set_student_id($student_id)
    {
        $this->student_id = $student_id;
    }

    /**
     * インターン体験記各投稿にいいねができるか判定する
     */
    public function intern_experience_like_check()
    {
        $db_calc = new Database();

        // 投稿にいいねできるか確認する。
        $sql = "SELECT * FROM intern_experience_like_tbl WHERE like_post_id = ? AND student_id = ?";

        $argument = [];
        $argument[] = strval($this->post_id);
        $argument[] = strval($this->student_id);

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }

    /**
     * インターン体験記各投稿についたいいね数を取得する
     */
    public function intern_experience_like_count()
    {
        $db_calc = new Database();

        $sql = 'SELECT * FROM intern_experience_like_tbl WHERE like_post_id = ?';

        $argument[] = strval($this->post_id);

        $result = $db_calc->data_select_count($sql, $argument);

        return $result;
    }

    /**
     * インターン体験記にいいねする
     */
    public function intern_experience_like()
    {
        $db_calc = new Database();

        $sql = "INSERT INTO `intern_experience_like_tbl` (`like_post_id`, `student_id`) VALUES (?, ?)";

        $argument = [];
        $argument[] = strval($this->post_id);
        $argument[] = strval($this->student_id);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }

    /**
     * インターン体験記のいいねを解除する
     */
    public function intern_experience_like_delete()
    {
        $db_calc = new Database();

        $sql = "DELETE FROM `intern_experience_like_tbl` WHERE like_post_id = ? AND student_id = ?";

        $argument = [];
        $argument[] = strval($this->post_id);
        $argument[] = strval($this->student_id);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }

    /**
     * ES体験記各投稿にいいねができるか判定する
     */
    public function es_experience_like_check($post_id, $student_id)
    {
        $db_calc = new Database();

        // 投稿にいいねできるか確認する。
        $sql = 'SELECT * FROM es_experience_like_tbl WHERE like_post_id = ? AND student_id = ?';

        $argument = [];
        $argument[] = strval($post_id);
        $argument[] = strval($student_id);

        $result = $db_calc->data_select_argument($sql, $argument);

        return $result;
    }

    /**
     * ES体験記各投稿についたいいね数を取得する
     */
    public function es_experience_like_count($post_id)
    {
        $db_calc = new Database();

        $sql = 'SELECT * FROM es_experience_like_tbl WHERE like_post_id = ?';

        $argument[] = strval($post_id);

        $result = $db_calc->data_select_count($sql, $argument);

        return $result;
    }

    /**
     * ES体験記にいいねする
     */
    public function es_experience_like($post_id, $student_id)
    {
        $db_calc = new Database();

        $sql = "INSERT INTO `es_experience_like_tbl` (`like_post_id`, `student_id`) VALUES (?, ?)";

        $argument = [];
        $argument[] = strval($post_id);
        $argument[] = strval($student_id);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }

    /**
     * ES体験記のいいねを解除する
     */
    public function es_experience_like_delete($post_id, $student_id)
    {
        $db_calc = new Database();

        $sql = "DELETE FROM `es_experience_like_tbl` WHERE like_post_id = ? AND student_id = ?";

        $argument = [];
        $argument[] = strval($post_id);
        $argument[] = strval($student_id);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }
}
