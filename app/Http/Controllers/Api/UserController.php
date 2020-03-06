<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'name.required'       => 'name is required',
            'name.string'         => 'name must be a string',
            'name.max'            => 'name must be a maximum of 255 characters',
            'email.required'      => 'email is required',
            'email.string'        => 'email must be a string',
            'email.email'         => 'email invalid',
            'email.max'           => 'email must be a maximum of 255 characters',
            'email.unique'        => 'email already exists',
            'password.min'        => 'password must be at least 6 characters',
            'password.max'        => 'password must be a maximum of 20 characters',
            'password.same'       => 'passwords not match',
            'repassword.min'      => 'confirm password must be at least 6 characters',
            'repassword.max'      => 'confirm password must be a maximum of 20 characters',
        ];
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'min:6|max:20|required_with:repassword|same:repassword',
            'repassword' => 'min:6|max:20'
        ], $messages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ]);
        }

        $selectedCompany = getSelectedCompany();

        if ($selectedCompany) {
            
            $user = new User([
                'company_id' => $selectedCompany->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'active' => $request->active
            ]);

            try {
                if ($user->save()) {
                    return response()->json([
                        'success' => true,
                        'user' => $user
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'error' => 'unexpected_error'
                    ]);    
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e
                ]);
            }

        } else {
            return response()->json([
                'success' => false,
                'error' => 'unauthorized'
            ], 401);    
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUser()
    {
        $me = Auth::user();
        $me->load('company');
        return $me;
    }

    public function getAllUsers() {
        $selectedCompany = getSelectedCompany();

        if ($selectedCompany) {
            return $selectedCompany->users;
        }

        return null;
    }

    public function logout() {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json([
            "success" => true,
            "message" => "Successfully logged out"
        ]);
    }

}
