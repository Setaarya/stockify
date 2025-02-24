<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->userService->validateUserData($request);
        $this->userService->createUser($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $this->userService->validateUserData($request, $user->id);
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        }
        $this->userService->updateUser($user, $validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
