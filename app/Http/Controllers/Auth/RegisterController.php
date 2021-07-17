<?php
namespace App\Http\Controllers\Auth;
use App\User;
use App\UserRoles;
use App\AppConst;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\EnvelopeEncryption;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use EnvelopeEncryption;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data[AppConst::EMAIL_HASH] = hash('sha256', $data[AppConst::EMAIL]);

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            AppConst::EMAIL_HASH => ['unique:users']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $key = self::decryptDataKey();
        $userdetails=User::create([
            'name' => self::EncryptedData($data['name'], $key),
            'avatar'=>'img/user-avatar.png',
            'email' => self::EncryptedData($data[AppConst::EMAIL], $key),
            'password' => Hash::make($data['password']),
            'email_hash' => hash('sha256', $data['email'])
        ]);
        UserRoles::create([
           'user_id'=>$userdetails->id,
           'role_id'=>2
        ]);
        return $userdetails;
    }
}
