<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
class Admin extends Controller
{
    public function getUsers(Request $request)
    {
        if ($request->ajax())
        {
            $users = User::select(['id', 'name', 'email']);
            return DataTables::of($users)
            ->addColumn('access' , function($user){return 'open';})
            ->make(true);
        }

    }
}
