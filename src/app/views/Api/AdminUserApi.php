<?php
namespace App\Views\Api;

use App\Db\UserHelper;
use Ramsey\Uuid\Uuid;
use Sobo_fw\Utils\App\AppKernel;
use Sobo_fw\Utils\App\AppMain;
use Sobo_fw\Utils\Db\DbConnectionStore;
use Sobo_fw\Utils\Form\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sobo_fw\Utils\Auth\Password;
use Sobo_fw\Utils\Db\DbHelper;

function blabla()
{
    echo "BLA BLA";
}





class AdminUserApi
{
    private function validateUserDataForInsert($req_array) {
        $errors = [];
        // sample validation - TODO real validator
        if (! isset($req_array) || empty($req_array)) {
            return new JsonResponse(["error" => "Invalid data"], 400);
        }

        if (! Validator::checkEmail('email', $req_array)) {
            $errors[] = 'Valid email is required';
        } elseif (! Validator::isEmailUnique(
            $req_array['email'],
            AppMain::instance()->getDefaultDbConnectionHandle(),
            'user_forms_user',
            'email')) {
            $errors[] = 'Email already exists';
        }

        if (! Validator::checkPassword('password', $req_array)) {
            $errors[] = 'Valid password is required';
        }

        return $errors;
    }


    public function getUser($id)
    {
        $conn = DbConnectionStore::instance()->getDbConnectionByHandle(
            AppMain::instance()->getDefaultDbConnectionHandle())->getConnection();

        $fields = ['id', 'email', 'first_name', 'last_name', 'is_staff', 'is_active', 'role',
            'no_failed_logins', 'failed_is_blocked', 'failed_is_blocked_thru'];
        $res = $conn->get('user_forms_user', $fields, ['id' => $id]);

        if(!$res) {
            return new JsonResponse(["errors" => ["User not found"]], 400);
        }

        $res['status'] = UserHelper::getUserStatus($res['is_active']);

        return new JsonResponse($res);
    }

    public static function test()
    {
        echo "TEST TEST TEST";
    }

    public function getUserList()
    {
        $conn = DbConnectionStore::instance()->getDbConnectionByHandle(
            AppMain::instance()->getDefaultDbConnectionHandle())->getConnection();

        $fields = ['id', 'email', 'first_name', 'last_name', 'is_staff', 'is_active', 'role',
            'no_failed_logins', 'failed_is_blocked', 'failed_is_blocked_thru'];

        $res_items = $conn->select('user_forms_user', $fields);
        if ($res_items) {
            foreach($res_items as $i => $res_item) {
                $res_items[$i]['status'] = UserHelper::getUserStatus($res_item['is_active']);
            }
        }

        $res       = [
            'data' => $res_items,
        ];

        return new JsonResponse($res);
    }

    // Content-Type: application/json
    // Accept: application/json
    public function createUser()
    {
        $req = AppKernel::instance()->getRequest();

        $req_array = $req->toArray();

        $errors = [];

        $errors = $this->validateUserDataForInsert($req_array);

        if ($errors) {
            return new JsonResponse(['errors' => $errors], 400);
        }

        $email    = $req_array['email'];
        $password = $req_array['password'];

        $first_name = Validator::fieldExistsAndNotEmpty('first_name', $req_array) ? $req_array['first_name'] : "";
        $last_name  = Validator::fieldExistsAndNotEmpty('last_name', $req_array) ? $req_array['last_name'] : "";

        $is_active = Validator::boolFieldExists('is_active', $req_array) ? Validator::normalizeBoolValue(
            'is_active', $req_array) : false;

        $is_staff = (Validator::boolFieldExists('is_staff', $req_array)) ? Validator::normalizeBoolValue(
            'is_staff', $req_array) : false;

        $failed_is_blocked = (Validator::boolFieldExists('failed_is_blocked', $req_array)) ? Validator::normalizeBoolValue(
            'failed_is_blocked', $req_array) : false;

        $pwdHash = Password::makeDjangoCompatiblePasswordHash($password);

        $dt_now_str = DbHelper::currentDateStrForDb();
        $data_out = [
            'email'             => $email,
            'first_name'        => $first_name,
            'last_name'         => $last_name,
            'password'          => $pwdHash,
            'is_active'         => $is_active,
            'is_staff'          => $is_staff,
            'is_superuser'      => $is_staff,
            'role'              => $is_staff ? "ADM" : "USR",
            'failed_is_blocked' => $failed_is_blocked,
            'no_failed_logins'  => 0,
            'created_at'        => $dt_now_str,
            'updated_at'        => $dt_now_str,
            "id"                => Uuid::uuid4()->toString(),
        ];

        $conn = DbConnectionStore::instance()->getDbConnectionByHandle(
            AppMain::instance()->getDefaultDbConnectionHandle())->getConnection();

        // https://www.php.net/manual/en/class.pdostatement.php
        $res = $conn->insert('user_forms_user', $data_out);

        // echo "\n\n <br />RESSSS".print_r($res->errorInfo(),true). " ERROR CODE: ".$res->errorCode(). " ROW COUNT: ".$res->rowCount(). "\n\n<br />";

        unset($data_out['password']);
        $data_out['status'] = UserHelper::getUserStatus($is_active);
        return new JsonResponse($data_out);
    }

    // accepts: application/json
    public function updateUser($id)
    {
        echo "<br />update user $id";
        $conn = DbConnectionStore::instance()->getDbConnectionByHandle(
            AppMain::instance()->getDefaultDbConnectionHandle())->getConnection();

        $fields = ['id', 'email', 'first_name', 'last_name', 'is_staff', 'is_active', 'role',
            'no_failed_logins', 'failed_is_blocked', 'failed_is_blocked_thru'];
        $user_in_db = $conn->get('user_forms_user', $fields, ['id' => $id]);

        if (! $user_in_db) {
            return new JsonResponse(["error" => "User does not exist"], 400);
        }

        $req = AppKernel::instance()->getRequest();

        $req_array = $req->toArray();

        $errors                 = [];
        $email_change_requested = false;

        // sample validation - TODO real validator
        if (! isset($req_array) || empty($req_array)) {
            return new JsonResponse(["error" => "Invalid data"]);
        }
        
        if (Validator::fieldExistsAndNotEmpty('email', 'req_array')) {
            if ($req_array['email'] != $user_in_db['email']) {
                if (Validator::anotherUserExistsWithThisEmail(
                    $req_array['email'],
                    $user_in_db['id'],
                    AppMain::instance()->getDefaultDbConnectionHandle(),
                    'user_forms_user',
                    'email')) {
                    $errors[] = "Email is already used by another user.";
                } elseif (! Validator::checkEmail('email', $req_array)) {
                    $errors[] = "Email is not valid.";
                } else {
                    $email_change_requested = true;
                }
            }
        }

        if ($errors) {
            return new JsonResponse(['errors' => $errors], 400);
        }

        $dt_now_str = $dt_now_str = DbHelper::currentDateStrForDb();
        $data_out = [
            'email'             => ($email_change_requested) ? $req_array['email'] : $user_in_db['email'],
            'first_name'        => Validator::fieldExistsFilledOrEmpty('first_name', $req_array) ? $req_array['first_name'] : $user_in_db['first_name'],
            'last_name'         => Validator::fieldExistsFilledOrEmpty('last_name', $req_array) ? $req_array['last_name'] : $user_in_db['last_name'],
            'is_active'         => Validator::boolFieldExists('is_active', $req_array) ? Validator::normalizeBoolValue('is_active', $req_array, false) : $user_in_db['is_active'],
            'is_staff'          => Validator::boolFieldExists('is_staff', $req_array) ? Validator::normalizeBoolValue('is_staff', $req_array, false) : $user_in_db['is_staff'],
            'failed_is_blocked' => Validator::boolFieldExists('failed_is_blocked', $req_array) ? Validator::normalizeBoolValue('failed_is_blocked', $req_array, false) : $user_in_db['failed_is_blocked'],
            'no_failed_logins'  => Validator::fieldExistsAndNumeric('no_failed_logins', $req_array) ? intval($req_array['no_failed_logins']) : $user_in_db['no_failed_logins'],
            'updated_at'        => $dt_now_str,
            'id'                => $user_in_db['id'],
        ];

        if (Validator::fieldExistsAndNotEmpty('password', $req_array)) {
            $pwdHash = Password::makeDjangoCompatiblePasswordHash($req_array['password']);
            $data_out['password'] = $pwdHash;
        }

        $data_out['is_superuser'] = $data_out['is_staff'];
        $data_out['role']         = $data_out['is_staff'] ? "ADM" : "USR";

        $conn = DbConnectionStore::instance()->getDbConnectionByHandle(
            AppMain::instance()->getDefaultDbConnectionHandle())->getConnection();

        // https://www.php.net/manual/en/class.pdostatement.php
        $res = $conn->update('user_forms_user', $data_out, ['id' => $id]);

        // echo "\n\n <br />RESSSS".print_r($res->errorInfo(),true). " ERROR CODE: ".$res->errorCode(). " ROW COUNT: ".$res->rowCount(). "\n\n<br />";

        unset($data_out['password']);
        $data_out['status'] = UserHelper::getUserStatus($data_out['is_active']);
        return new JsonResponse($data_out);
    }

    public function deleteUser($id)
    {
        $conn = DbConnectionStore::instance()->getDbConnectionByHandle(
            AppMain::instance()->getDefaultDbConnectionHandle())->getConnection();

        $res = $conn->delete('user_forms_user', ['id' => $id]);
        if ($res->errorCode() == 0) {
            return new JsonResponse([]);
        } else {
            return new JsonResponse([], 400);
        }

    }

}
