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
}
