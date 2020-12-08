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
}
