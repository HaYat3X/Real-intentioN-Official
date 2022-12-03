<?php

class Session
{
    private $csrf_token = "";

    /**
     * csrfトークンを発行する
     * @param null
     * @return string
     * single_unit_test ok
     */
    public function create_csrf_token()
    {
        $this->csrf_token = $_SESSION['csrf_token'];
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(24));
        return $this->csrf_token;
    }

    /**
     * csrfトークンの存在確認と正誤判定
     * @param $csrf_token
     * @return bool
     * single_unit_test ok
     */
    public function csrf_match_check($csrf_token)
    {
        $this->csrf_token = $_SESSION['csrf_token'];
        if ($this->csrf_token !== $csrf_token) {
            return false;
        }

        return true;
    }

    /**
     * csrfセッション情報消去
     * @param null
     * @return null
     * single_unit_test ok
     */
    public function csrf_token_unset()
    {
        unset($_SESSION['csrf_token']);
    }
}
