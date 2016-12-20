<?php

namespace App;
use Laravel\Socialite\Contracts\User as ProviderUser;
use App\User;

class SocialAccountService {

    public function createOrGetUser(ProviderUser $providerUser) {
        
        $account = SocialAccount::whereProvider('facebook')
                ->whereProviderUserId($providerUser->getId())
                ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new User([
                'facebook_id' => $providerUser->getId(),
                //'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                            'email' => $providerUser->getEmail(),
                            'first_name' => $providerUser->getName(),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }

}
