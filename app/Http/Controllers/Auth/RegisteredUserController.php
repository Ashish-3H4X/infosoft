<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    /**
     * Registration form disabled.
     */
    public function create()
    {
        abort(403, 'Registration is disabled.');
    }

    /**
     * Registration action disabled.
     */
    public function store(Request $request)
    {
        abort(403, 'Registration is disabled.');
    }
}
