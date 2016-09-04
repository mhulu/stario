<?php
namespace Star\Icenter\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Star\Icenter\Events\UpdateUserEvent;
use Star\Icenter\Forms\SignUpFormRequest;
use Star\Icenter\Forms\UserInfoRequest;
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

        public function signup(SignUpFormRequest $request)
        {
          	return $request->persist();
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
  	public function update(UserInfoRequest $request, $id)
  	{
  		$data = $request->all();
	  	Event::fire(new UpdateUserEvent(User::find(Auth::user()->id)));
	  	if ($this->repo->updateUser($id, $data)) {
		  	return response()->json([
		          'result' => '更改成功'
		          ], 200);
	  	}
  	}
  	public function destroy($id)
  	{
  		# code...
  	}
} 