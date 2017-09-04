<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function findUser($query)
    {
      return User::select('name')->where('name', 'regexp', '/'.$query.'/i')->get();
    }
}
