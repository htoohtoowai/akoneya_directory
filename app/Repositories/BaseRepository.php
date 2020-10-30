<?php
namespace App\Repositories;

use App\User;
use App\PersonalInformation;
use Illuminate\Support\Facades\Hash;

class BaseRepository
{
    public function __construct(User $userModel, PersonalInformation $personalInfoModel)
    {
        $this->userModel = $userModel;
        $this->personalInfoModel = $personalInfoModel;
    }
    function checkEmail($email){
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
    }

    protected function cloneToProfile($data, $userId)
    {
        $personalInfo = $this->personalInfoModel::where('client_user_id', $userId)->first();
       
        if ($personalInfo == null) {
            if ($data['type'] == "phone") {
                $this->personalInfoModel::create(['client_user_id'=>$userId,
                                            'name'=>$data['name'],
                                            'image' => $data['image'],
                                            'phone'=>$data['phone']]);
            } else {
                $this->personalInfoModel::create(['client_user_id'=>$userId,
                                            'name'=>$data['name'],
                                            'email'=>$data['email'],
                                            'image' => $data['image']]);
            }
        }
    }
    protected function generateNumericOTP($num)
    {
        $generator = rand();
        $result = "";
        for ($i = 1; $i <= $num; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
        return $result;
    }
    protected function toRegister(array $data)
    {
        $data['active_status'] = "pending";
        $data['login_type'] = $data['type'];
        $data['password'] = Hash::make($data['password']);
        return $this->userModel->create($data);
    }
}
