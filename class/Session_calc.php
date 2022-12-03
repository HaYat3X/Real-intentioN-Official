<?php

class Session
{
    /**
     * csrfトークン発行
     * @param 
     * @return token
     * unit test ok
     */
    public function create_csrf_token()
    {
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(24));
        return $_SESSION['csrf_token'];
    }

    /**
     * csrfトークンのチェック
     * @param $csrf_token
     * @return true
     * unit test ok
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
     * @param
     * @return 
     * unit test ok
     */
    public function csrf_token_unset()
    {
        unset($_SESSION['csrf_token']);
    }









    /**
     * メールアドレスに送信したトークン情報を格納するセッション
     * @param
     * @return 
     */
    public function create_email_token($send_token)
    {
        $_SESSION['email_token'] = $send_token;
    }

    /**
     * メールアドレスに送信したトークン情報を格納するセッション
     * @param
     * @return 
     */
    public function check_email_token()
    {
        if (!$_SESSION['email_token']) {
            return false;
        }

        return $_SESSION['email_token'];
    }

    /**
     * email_token削除
     * @param
     * @return 
     * unit test ok
     */
    public function email_token_unset()
    {
        unset($_SESSION['email_token']);
    }
}
