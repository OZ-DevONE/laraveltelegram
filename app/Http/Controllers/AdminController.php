<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.admin', compact('users'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.admin')->with('success', 'Пользователь удалён');
    }
}
