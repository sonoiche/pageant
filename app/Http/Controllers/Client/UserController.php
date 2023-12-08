<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;

class UserController extends Controller
{
    public function index()
    {
        return view('client.settings.index');
    }

    public function store(AccountRequest $request)
    {
        $id     = auth()->user()->id;
        $user   = User::find($id);
        $user->fname = $request['fname'];
        $user->mname = $request['mname'];
        $user->lname = $request['lname'];
        if (isset($request['password'])) {
            $user->password = bcrypt($request['password']);
        }
        $user->save();

        return redirect()->back()->with('success', 'Account information has been saved.');
    }
}
