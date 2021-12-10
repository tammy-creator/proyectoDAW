<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Notifications\UserNotification;


class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:25'],
            'apellidos' => ['required', 'string', 'max:55'],
            'direccion' => ['required', 'string', 'max:55'],
            'telefono' => ['required', 'numeric','digits:9'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                 Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'apellidos' => $input['apellidos'],
            'direccion' => $input['direccion'],
            'telefono' => $input['telefono'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->assignRole('User');

         User::all()
         ->only(PR_ROL_ADMINISTRADOR_ID)
         ->each(function(User $item) use ($user){
             $item->notify(new UserNotification($user));
         });

        return $user;
    }
}
