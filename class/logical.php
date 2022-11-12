<?php 

// DB
class SystemLogic{
    // SELECTメソッド引数なし
    public static function db_select($sql){

    }

    // SELECTメソッド引数あり、STring型が引数の場合
    public static function db_select_argument_str($sql, $argument_str){

    }
    
    // SELECtメソッド引数あり、Int型
    public static function db_select_argument_int($sql, $argument_int){

    }

    // ログインメソッドは作成必要

    // INSERT 型の定義は不必要？
    // db_update($sql, $insert_data)

    // UPDATE 型の定義は不必要？
    // db_update($sql, $update_data)

    // DELETE 型の定義は不必要？
    // db_delete($sql, $delete_data)
}












// 学生用
class Test2{
    // メールアドレス存在確認
    // user_exist_check($email)

    // トークン送信

}

// ログインチェック
// login_check_student()
// login_check_staff()
// 職員用