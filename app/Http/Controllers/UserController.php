<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
     public function index()
     {
         $users = User::all();

         return response()->json($users);
     }

     public function create(Request $request)
     {
         $user = new User;

         $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8',
         ]);

         $user->name          = $request->name;
         $user->email         = $request->email;
         $user->password      = $request->password;
         $user->gender        = $request->gender;
         
         $user->save();

         return response()->json($user, 201);
     }

     public function show($id)
     {
         $user = User::find($id);

         if ($user === null) {
            return response()->json('User not found', 404);
        }

         return response()->json($user);
     }

     public function update(Request $request, $id)
     {
         $user = User::findorFail($id);
         $user->update($request->all());

         return response()->json($user);
     }

     public function delete($id)
     {
         User::findorFail($id)->delete();
         return response()->json('User successfully deleted');
     }
}
