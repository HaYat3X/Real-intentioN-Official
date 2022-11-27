<?php

require_once '/Applications/MAMP/htdocs/Deliverables4/class/Database_calc.php';

class Register
{
    // プロパティ定義初期化
    private string $email = "";

    /**
     * emailプロパティに値をセット
     * @param $email
     * @return void
     */
    public function set_email($email)
    {
        $this->email = $email;
    }

    /**
     * 登録済みかどうか判定する
     * @param $email
     * @return false
     */
    public function registered_check($sql)
    {
        $pdo_calc = new Database();

        $argument[] = strval($this->email);
        $result = $pdo_calc->data_select_argument($sql, $argument);

        return $result;
    }

    /**
     * メールアドレスにトークンを送信する (メールアドレス認証のため)
     * @param \src\Userview\register\provisional_registration.php $email, $token
     * @return token
     * @return false
     */
    public function send_token()
    {
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
        $to = $this->email;
        $subject = "メールアドレス認証トークン";
        $token = rand();
        $message = '認証トークンは' . '"' . $token . '"' . 'です。';
        $headers = "From: hayate.syukatu1@gmail.com";
        mb_send_mail($to, $subject, $message, $headers);
        return $token;
    }
}
