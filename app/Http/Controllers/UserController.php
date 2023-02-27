<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        if (Gate::denies('access-users'))
            return response()->json([
                'status' => 'fail',
                'message' => 'you dont have access',
            ], 403);

        $users = User::all();

        return response()->json([
            'status' => 'success',
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if (! auth()->user()->isAdmin())
            return response()->json([
                'statuss' => 'fail',
                'message' => 'you dont have permission',
            ], 403);

        $user = User::create($request->only(['first_name', 'last_name', 'email', 'password']));

        $roles = [3];
        if ($request->role === 'admin' && auth()->user()->isSuperAdmin() ) $roles = [2, 3];
        else if ($request->role === 'superadmin' && auth()->user()->isSuperAdmin() ) $roles = [1, 2, 3];

        $user->roles()->attach($roles);

        if ($user)
            return response()->json([
                'status' => 'success',
                'user' => $user,
            ]);
        
        return response()->json([
            'status' => 'fail',
            'message' => 'failed creating user',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (! $user)
            return response()->json([
                'status' => 'fail',
                'message' => 'user not found',
            ], 404);
        
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (! $user)
            return response()->json([
                'status' => 'fail',
                'message' => 'user not found',
            ], 404);
        
        if ($user->delete())
            return response()->json([
                'status' => 'success',
                'message' => 'user deleted with success',
            ]);
        
        return response()->json([
            'status' => 'fail',
            'message' => 'delte failed',
        ], 503);
    }
}