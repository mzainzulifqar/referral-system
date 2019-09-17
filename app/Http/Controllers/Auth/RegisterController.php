<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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

    public $counter = 0;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
        // dd($data);
        if(isset($data['referral_id']))
        {
            $referral = User::where('referral_id',$data['referral_id'])->first();
                
                if($referral)
                {
                    // $data = User::find($referral->id)->owner;
                    $referral->balance = $referral->balance + 10;
                    if($referral->update())
                    {
                       $this->percent_to_parent($referral->id);
                    }
                }

        }

        $user =  User::create([

            'name' => $data['name'],
            'email' => $data['email'],
            'referral_id' => uniqid('ref'),
            'referred_by' => $referral->id ?? 0,
            'password' => Hash::make($data['password']),
        ]);

        $this->counter = 0;
        return $user;

        
    }

    public function percent_to_parent($id){

        
        
        $data_parent = User::find($id);
        // dd($data_parent);
        
        if($data_parent)
        {   
            if($data_parent->owner()->count() > 0)
            {


            $this->counter = $this->counter + 1;

            $data_parent->owner->balance = $data_parent->owner->balance  + 10;
            if($data_parent->owner->update() && ($this->counter < 6))
            {
                $this->percent_to_parent($data_parent->owner->id);
            }

            else 
            {


            return false;
        }
            
        }
            else
            {
                return false;
            }
        }
        else
        {   
            
            return false;
        }
        
    }


}
