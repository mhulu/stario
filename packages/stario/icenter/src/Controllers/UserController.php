<?php
namespace Star\Icenter\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Star\Icenter\Repos\Eloquent\UserRepo;
use Star\Icenter\User;

/**
 *
 */
class UserController extends Controller
{	
	protected $repo;
	function __construct()
	{
		$this->repo = new UserRepo();
	}
	public function index()
	{
		return $this->repo->getUserList();
	}

	public function store(Request $request)
	{
		// return $this->repo->createUser($request);
	}
	public function show($id)
	{
              if ($id == 'me') {
                $id = Auth::user()->id;
              }
		return $this->repo->getUserInfo($id);
  	}
  	public function edit($id=null)
  	{
  		# code...
  	}
  	public function update(Request $request)
  	{
              $data = array_except($request->all(), ['menuList']);
              return $data;
              return $this->repo->createUser($data);
  	}
  	public function destroy($id)
  	{
  		# code...
  	}
} 