<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

class UsersController extends Controller
{
    //
    public function index()
    {
      $users = User::get();
      return response()->json([
        'status' => 'ok',
        'code' => 200,
        'messages' => ['User list was retrieved'],
        'data' => [
          'users' => $users
        ]
      ]);
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'name' => 'required',
          'email' => 'required|unique:users',
          'password' => 'required|confirmed',
          'phone_number' => 'required|size:10',
          'mobile_number' => 'required|size:10',
          'school' => 'required',

      ]);

      if ($validator->fails()) {
        return response()->json([
          'status' => 'error',
          'code' => 422,
          'messages' => $validator->errors()->all(),
          'data' => []
        ]);
      }

      $user = User::create($request->all());
      return response()->json([
        'status' => 'ok',
        'code' => 201,
        'messages' => ['The user was successfully created'],
        'data' => [
          'user' => $user->fresh()
        ]
      ]);
    }

    public function show(User $user)
    {
      return response()->json([
        'status' => 'ok',
        'code' => 201,
        'messages' => ['The user details were retrieved'],
        'data' => [
          'user' => $user->fresh()
        ]
      ]);
    }

    public function update(Request $request, User $user)
    {
      $validator = Validator::make($request->all(), [
          'name' => 'string',
          'email' => 'string|unique:users,email,'.$user->id,
          'password' => 'string|confirmed',
          'phone_number' => 'size:10',
          'mobile_number' => 'size:10',
          'school' => 'string',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'status' => 'error',
          'code' => 422,
          'messages' => $validator->errors()->all(),
          'data' => []
        ]);
      }

      $user->update($request->all());

      return response()->json([
        'status' => 'ok',
        'code' => 201,
        'messages' => ['The user information was updated'],
        'data' => [
          'user' => $user->fresh()
        ]
      ]);
    }

    public function destroy(User $user)
    {
      $user->delete();
      return response()->json([
        'status' => 'ok',
        'code' => 200,
        'messages' => ['User was deleted'],
        'data' => [
          'user' => $user
        ]
      ]);
    }
}
