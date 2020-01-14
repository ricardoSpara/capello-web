<?php

namespace Capello\Http\Controllers\Auth;

use Capello\User;
use Capello\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
    public function __construct(Request $request)
    {
        $this->request = $request;
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
            'image' => 'nullable|mimes:jpeg,jpg,png,JPG',
            'cpf' => 'required|min:14|unique:users',
            'birth' => 'required|min:10',
            'gender' => 'required|min:1',
            'phone' => 'required|min:14',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Capello\User
     */
    protected function create(array $data)
    {

        if($this->request->hasFile('image') && $this->request->file('image')->isValid()) {
            $name = str_random(5).kebab_case($data['name']).str_random(5);
            $extension = $this->request->image->extension();
            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;
            $upload = $this->request->image->storeAs('public/users', $nameFile);
            if(!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload da imagem!');
        }


        $data['birth'] = \DateTime::createFromFormat('d/m/Y', $data['birth']);
        $data['birth'] = $data['birth']->format('Y-m-d');
        if(isset($data['isStudent'])) {
            $data['access_level'] = 1;
        } elseif(isset($data['isTeacher'])) {
            $data['access_level'] = 2;
        } else {
            $data['access_level'] = 0;
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'cpf' => $data['cpf'],
            'birth' => $data['birth'],
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'description' => $data['description'],
            'course_id' => $data['course_id'],
            'degree' => $data['degree'],
            'ra' => $data['ra'],
            'access_level' => $data['access_level'],
            'image' => isset($data['image']) ? $data['image']: null,
        ]);
    }
}
