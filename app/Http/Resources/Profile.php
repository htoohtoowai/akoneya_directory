<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
class Profile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
            $loginType = User::where('id', $this->client_user_id)->select('login_type')->first();
            return[
                    'id' => $this->client_user_id,
                    'name' => $this->name ?? "",
                    'image' =>  $this->image ?? "",
                    'phone' => $this->phone ?? "",
                    'email'=> $this->email ?? "",
                    'gender'=> $this->gender ?? "",
                    'dateOfBirth'=> $this->date_of_birth ?? "",
                    'bio'=> $this->bio ?? "",
                    'address' => $this->address ?? "",
                    'loginType' =>$loginType->login_type ?? '' ,
                  
            ];
    }
}
