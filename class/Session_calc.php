<?php

class Session
{
    /**
     * csrfトークンを発行する
     */
    public function create_csrf_token()
    {
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(24));
        return $_SESSION['csrf_token'];
    }

    /**
     * csrfトークンの存在確認と正誤判定
     */
    public function csrf_match_check($csrf_token)
    {

        if ($_SESSION['csrf_token'] !== $csrf_token) {
            return false;
        }

        return true;
    }

    /**
     * csrfセッション情報消去
     */
    public function csrf_token_unset()
    {
        unset($_SESSION['csrf_token']);
    }

    /**
     * 学生ログインが成功したらセッションを発行する。
     */
    public function create_student_login_session($login_data)
    {
        $_SESSION['student_login_data'] = $login_data;
    }

    /**
     * 学生ログインチェックをする
     */
    public function student_login_check()
    {
        if (!$_SESSION['student_login_data']) {
            return false;
        }

        return $_SESSION['student_login_data'];
    }

    /**
     * 職員ログインが成功したらセッションを発行する。
     */
    public function create_staff_login_session($login_data)
    {
        $_SESSION['staff_login_data'] = $login_data;
    }

    /**
     * 職員ログインチェックをする
     */
    public function staff_login_check()
    {
        if (!$_SESSION['staff_login_data']) {
            return false;
        }

        return $_SESSION['staff_login_data'];
    }
}
