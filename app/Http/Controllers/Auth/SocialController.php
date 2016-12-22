<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Socialite;

use App\User;
use App\SocialAccount;

class SocialController extends Controller
{
    protected $redirectTo = '/';        //your-redirect-url-after-login

    // twitter

    public function getTwitterAuth()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function getTwitterAuthCallback() {
        try {
            $twitterUser = Socialite::driver('twitter')->user();
        } catch (\Exception $e) {
            return redirct("/");
        }
        if ($twitterUser) {
            $user = $this->createOrGetUser($twitterUser, 'twitter');
            Auth::login($user, true);
            return redirect($this->redirectTo);
        } else {
            return 'something went wrong';
        }
    }

    // facebook

    public function getFacebookAuth()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function getFacebookAuthCallback() {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirct("/");
        }
        if ($facebookUser) {
            $user = $this->createOrGetUser($facebookUser, 'facebook');
            Auth::login($user, true);
            return redirect($this->redirectTo);
        } else {
            return 'something went wrong';
        }
        // $facebookUser = Socialite::driver('facebook')->stateless()->user(); // (1)

        // $user = $this->createOrGetUser($facebookUser, 'facebook');
        // Auth::login($user, true);

        // return redirect($this->redirectTo);
    }

    // Google

    public function getGoogleAuth()
    {
        return Socialite::driver('google')->redirect();
    }

    public function getGoogleAuthCallback() {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirct("/");
        }
        if ($googleUser) {
            $user = $this->createOrGetUser($googleUser, 'google');
            Auth::login($user, true);
            return redirect($this->redirectTo);
        } else {
            return 'something went wrong';
        }
    }

    public function socialLogin() {
        return view('auth.social');
    }

    public function createOrGetUser($providerUser, $provider)
    {
        $account = SocialAccount::firstOrCreate([
            'provider_user_id' => $providerUser->getId(),
            'provider'         => $provider,
        ]);

        if (empty($account->user)) {
            $user = User::create([
                'name'   => $providerUser->getName(),
                'email'  => $providerUser->getEmail(),
                'avatar' => $providerUser->getAvatar(),
            ]);
            $account->user()->associate($user);
        }

        $account->provider_access_token = $providerUser->token;
        $account->save();

        return $account->user;
    }
}