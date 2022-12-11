<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Update
{
    /**
     * インターン体験記を編集する
     */
    public function intern_experience_update($user_id, $company, $format, $content, $question, $answer, $ster, $field, $post_id)
    {
        $db_calc = new Database();

        $sql = "UPDATE `intern_experience_tbl` SET `user_id` = ?, `company` = ?, `format` = ?, `content` = ?, `question` = ?, `answer` = ?, `ster` = ?, `field` = ? WHERE post_id = ?";

        $argument = [];
        $argument[] = strval($user_id);
        $argument[] = strval($company);
        $argument[] = strval($format);
        $argument[] = strval($content);
        $argument[] = strval($question);
        $argument[] = strval($answer);
        $argument[] = strval($ster);
        $argument[] = strval($field);
        $argument[] = strval($post_id);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }

    /**
     * ES体験記を編集する
     */
    public function es_experience_update($user_id, $company, $question, $answer, $field, $post_id)
    {
        $db_calc = new Database();

        $sql = "UPDATE `es_experience_tbl` SET `student_id` = ?, `company` = ?, `question` = ?, `answer` = ?, `field` = ? WHERE post_id = ?";

        $argument = [];
        $argument[] = strval($user_id);
        $argument[] = strval($company);
        $argument[] = strval($question);
        $argument[] = strval($answer);
        $argument[] = strval($field);
        $argument[] = strval($post_id);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }
}
