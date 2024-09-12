<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('products')->orderBy('id', 'asc')->get();

        return Inertia::render('User/Index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        User::create([
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'role' => $request->validated()['role'],
            'password' => Hash::make($request->validated()['password']),
        ]);

        return Redirect::route('users.index')->with('message', 'User created successfully.')->with('timestamps', now());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['products' => ['category']])->where('id', $id)->first();

        if (! $user) {
            abort(404);
        }

        $categories = Category::all();

        return Inertia::render('User/Detail', ['user' => $user, 'categories' => $categories]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $user = User::where('id', $id)->first();

        if (! $user) {
            abort(404);
        }

        $user->update($request->validated());

        return back()->with('message', 'User updated successfully.')->with('timestamps', now());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->first();

        if (! $user) {
            abort(404);
        }

        $user->delete();

        return back()->with('message', 'User deleted successfully.')->with('timestamps', now());
    }
}
