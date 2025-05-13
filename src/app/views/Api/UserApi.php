<?php
namespace App\Views\Api;

use App\Db\UserHelper;
use Sobo_fw\Utils\App\AppKernel;
use Sobo_fw\Utils\App\AppMain;
use Sobo_fw\Utils\Db\DbConnectionStore;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sobo_fw\Utils\Form\Validator;
use Sobo_fw\Utils\Auth\Password;


function user_register()
{

}

function user_register_confirm()
{

}
function user_reset_password_request()
{

}
function user_reset_password_confirm()
{

}

function user_login()
{
    $errors = [];
    $conn = DbConnectionStore::instance()->getDbConnectionByHandle(
        AppMain::instance()->getDefaultDbConnectionHandle())->getConnection();

    $req = AppKernel::instance()->getRequest();
    $req_array = $req->toArray();

    if (! isset($req_array) || empty($req_array)) {
        return new JsonResponse(["error" => "Invalid data"], 400);
    }

    if (!Validator::fieldExistsAndNotEmpty('email', $req_array)) {
        $errors []= 'User email is required';
    }

    if (!Validator::fieldExistsAndNotEmpty('password', $req_array)) {
        $errors []= 'User password is required';
    }
    
    if ($errors) {
        return new JsonResponse(['errors' => $errors], 400);
    }

    $email = $req_array['email'];
    $password = $req_array['password'];

    $fields = ['id','email','first_name', 'last_name', 'is_staff', 'is_active', 'password'];

    $user_in_db = $conn->get('user_forms_user', $fields, ['email' => $email]);

    if (!$user_in_db) {
        $errors []= 'email or password is invalid-1';
        return new JsonResponse(['errors' => $errors], 400);
    }

    $password_hash = $user_in_db['password'];

    if(!Password::checkPasswordDjangoCompatiblePasswordHash($password, $password_hash)) {
        $errors []= 'email or password is invalid-2';
        return new JsonResponse(['errors' => $errors], 400);
    }

    $status = UserHelper::getUserStatus($user_in_db['is_active']);
    $token = '';

    /*
        .venv/lib/python3.9/site-packages/rest_framework/authtoken/models.py
        token, user = utils.UserFormsAuth.generate_token_for_login_data(
            username=ser.validated_data['email'], password=ser.validated_data['password'])
        
                    @classmethod
                    def generate_token_for_login_data(cls, username: str, password: str):
                        try: 
                            user = cls.authenticate_username_password(username, password)
                        except(PermissionDenied):
                            return None, None

                        token, is_created = Token.objects.get_or_create(user=user)
                        return token, user

        if token and user:
            res = {
                "id": user.id,
                "status": user.status,
                "email": ser.validated_data['email'],
                "token": token.key,
                "first_name": user.first_name,
                "last_name": user.last_name,
                "is_staff": user.is_staff,
                # "is_active": user.is_active,
            }
            print("\n\nRES::: ", res, "aaaaa\n\n")
            return Response(res, status=200)
    */


    $res_out = [
        'id' => $user_in_db['id'],
        'status' => $status,
        'email' => $user_in_db['email'],
        'token' => $token,
        'first_name' => $user_in_db['first_name'],
        'last_name' => $user_in_db['last_name'],
        'is_staff' => $user_in_db['is_staff']
    ];


    return new JsonResponse($res_out, 200);
}

function user_logout()
{

}
