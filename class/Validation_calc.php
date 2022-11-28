<?php

class ValidationCheck
{
    private String $errorMsg;

    public function __construct(String $errorMsg)
    {
        $this->errorMsg = $errorMsg;
    }

    /**
     * 神戸電子のメールアドレスでないメールアドレスが入力された場合エラーを出す
     * @param $email
     * @return true
     * @return false
     */
    public function not_yet_kic($email)
    {
        // 正規表現で神戸電子以外のメールアドレスは登録できないようにする
        if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@st.kobedenshi.ac.jp/", $email)) {
            $this->errorMsg = '@st.kobedenshi.ac.jpのメールアドレスを入力してください。';
            return false;
        }

        return true;
    }

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

            return true;
        }
    }

    /**
     * バリデーションにj引っ掛かった場合のエラーメッセージを表示
     * @param 
     * @return errorMsg
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
}
