<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class ShowProfile extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $user 
     * 
     * @return UserResource
     */
    public function __invoke(User $user)
    {
        return new UserResource($user);
    }
}
