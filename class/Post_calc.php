<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Post
{
    /**
     * インターン体験記を新規投稿する
     */
    public function intern_experience_new_post($user_id, $company, $format, $content, $question, $answer, $ster, $field)
    {
        $db_calc = new Database();

        $sql = 'INSERT INTO `intern_experience_tbl` (`user_id`, `company`, `format`, `content`, `question`, `answer`, `ster`, `field`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

        $argument = [];
        $argument[] = strval($user_id);
        $argument[] = strval($company);
        $argument[] = strval($format);
        $argument[] = strval($content);
        $argument[] = strval($question);
        $argument[] = strval($answer);
        $argument[] = strval($ster);
        $argument[] = strval($field);

        $result = $db_calc->data_various_kinds($sql, $argument);

        return $result;
    }
}
