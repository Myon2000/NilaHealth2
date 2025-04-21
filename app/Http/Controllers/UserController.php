<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // ambil arah sort yang diinginkan, default newest first
        $direction = $request->get('direction', 'desc') === 'asc' ? 'asc' : 'desc';

        // hanya role user, urut berdasarkan last_login
        $users = User::where('role', 'user')
                     ->orderBy('last_login', $direction)
                     ->get();

        return view('admin.pages.edituser.edituser', compact('users', 'direction'));
    }

    public function destroy(User $user)
    {
        abort_if($user->role !== 'user', 403);

        $user->delete();
        return redirect()->route('admin.users')
                         ->with('status', "User “{$user->name}” berhasil dihapus.");
    }
}
