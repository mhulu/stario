<?php
namespace Star\Icenter\Controllers;

use App\Http\Controllers\Controller;
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
	public function create()
	{
        //
	}
	public function store(Request $request)
	{
		return $this->repo->create($request);
	}
	public function show($id=null)
	{
              if (empty($id)) {
                $id = Auth::user()->id;
              }
		return $this->repo->getUserInfo($id);
  	}
  	public function edit($id=null)
  	{
  		# code...
  	}
  	public function update(Request $request, $id)
  	{
  		# code...
  	}
  	public function destroy($id)
  	{
  		# code...
  	}
} 