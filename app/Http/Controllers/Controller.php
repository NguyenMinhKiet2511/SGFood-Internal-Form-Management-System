<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // public function index()
    // {
    //    $users = User::all(); 
    //    return view('admin.index', compact('users'));
    // }

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

    // public function storeUser(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required',
    //         'role' => 'required|in:user,admin',
    //         'department' => 'required|in:IT,HR,Finance,Sale,Logistic,Production',
    //     ]);

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'role' => $request->role,
    //         'department' => $request->department,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     return redirect()->route('admin.index')->with('success', 'User created successfully.');
    // }

    // public function editUser($id)
    // {
    //     $user = User::findOrFail($id);
    //     return view('admin.edit', compact('user'));
    // }

    // public function updateUser(Request $request, $id)
    // {   
        
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email,'.$id,
    //         'role' => 'required|in:user,admin',
    //         'department' => 'required|in:IT,HR,Finance,Sale,Logistic,Production',
    //     ]);

    //     $user = User::findOrFail($id);
    //     $user->update([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'role' => $request->role,
    //         'department' => $request->department, 
    //     ]);
        

    //     return redirect()->route('admin.index')->with('success', "User updated successfully");

    // }
    // public function deleteUser($id)
    // {
    // // $user = User::findOrFail($id);

    
    // // if (Auth::id() == $user->id) {
    // //     return redirect()->route('admin.index')->with('error', 'You cannot delete yourself.');
    // // }

    // // $user->delete();
    // // return redirect()->route('admin.index')->with('success', 'User deleted!');

}
