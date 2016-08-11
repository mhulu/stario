<?php
namespace Star\Icenter\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Star\Icenter\Repos\Eloquent\UserRepo;

/**
 *
 */
class UserController extends Controller
{
  public function me()
  {
    return User::find(Auth::user()->id)->all();
  }
} 