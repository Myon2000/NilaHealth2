<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $direction = $request->get('direction', 'desc') === 'asc' ? 'asc' : 'desc';

        $users = User::where('role', 'user')
                     ->orderBy('last_login', $direction)
                     ->get();

        return view('admin.pages.edituser.edituser', compact('users', 'direction'));
    }

    public function destroy(User $user)
    {
        abort_if($user->role !== 'user', 403);

        $user->delete();
        return redirect()->route('admin.users.index')
                         ->with('status', "User “{$user->name}” berhasil dihapus.");
    }
}
