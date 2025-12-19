<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); 
        return view('admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */

    
    // public function login(){
    //     return view('user.login');
    // }

    // public function check_login(){
    //     request()->validate([
    //         'email' => 'required|email|exists:users',
    //         'password' => 'required',
    //     ]);

    //     $users = request()->all('email','password');
    //     if (Auth::attempt($users)){
    //         return redirect()->route('admin.index');   
    //     }
    //     return redirect()->back();
    // } 

    // 
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required|in:user,admin,manager,director',
            'department' => 'required|in:IT,HR,Finance,Sale,Logistic,Production',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'department' => $request->department,
            'password' => Hash::make($request->password),
        ]);

       return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'department' => $user->department,
            'created_at' => $user->created_at->toIso8601String()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(Request $request, string $id)
    {
        
        $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'department' => 'required',
        'role' => 'required',
    ]);

        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'department', 'role']));

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $user = User::findOrFail($id);

    if (Auth::id() == $user->id) {
        return redirect()->route('admin.index')->with('error', 'You cannot delete yourself.');
    }

    $user->delete();
    return redirect()->route('admin.index')->with('success', 'User deleted!');
    }
}
