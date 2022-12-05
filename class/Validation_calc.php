<?php

class ValidationCheck
{
    private $errorMsg = "";

    /**
     * 神戸電子のメールアドレスでないメールアドレスが入力された場合エラーを出す
     */
    public function not_yet_kic($email)
    {
        if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@st.kobedenshi.ac.jp/", $email)) {
            $this->errorMsg = '@st.kobedenshi.ac.jpのメールアドレスを入力してください。';
            return false;
        }

        return true;
    }

    /**
     * フォームの未入力、未選択をチェックする
     */
    public function not_yet_entered($val_check_arr)
    {
        foreach ($val_check_arr as $val) {
            if ($val == "") {
                $this->errorMsg = '未入力の項目があります。';
                return false;
            } elseif ($val === '-- 選択してください --') {
                $this->errorMsg = '未選択の項目があります。';
                return false;
            }
        }

        return true;
    }

    /**
     * パスワードが半角英数字8文字以上であることをチェックする
     */
    public function password_check($password)
    {
        if (preg_match("/\A[!-~]{8, 100}\z/", $password)) {
            $this->errorMsg = 'パスワードは英数字8文字以上で作成してください。';
            return false;
        }

        return true;
    }

    /**
     * バリデーションにj引っ掛かった場合のエラーメッセージを表示
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
}
