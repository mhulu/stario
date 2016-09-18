<?php
namespace Star\Health\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Star\Health\Repos\Eloquent\PopService;
use Star\utils\Serializer;

class PopController extends Controller
{
	protected $popService;
	public function __construct(PopService $popService)
	{	
		$this->middleware('jwt.auth', ['except' => ['server']]);
		$this->popService = $popService;
	}
	
	/**
	 * 用于接受一体机传输过来的数据并同步至数据库
	 * @return 同步成功则返回Uray需要的WS标识
	 */
	public function server()
	{
		$result = Serializer::xmlDecode(file_get_contents('php://input'));
		$data = Serializer::parse($result['v:Body']['getUpload']['dataXML']['#']);
		return $this->popService->create($data);
	}
	public function index(Request $request)
	{	
		$paginate = empty($request->paginate) ? 15 : $request->paginate;
		return $this->popService->index($paginate);
	}
	public function show($id)
	{
		return $this->popService->show($id);
	}
	public function update(Request $request, $id)
	{
		return $this->popService->update($request->all(), $id);
	}
	public function updatePassword(Request $request, $id)
	{
		return $this->popService->updatePassword($request->password, $id);
	}
	public function destroy($id)
	{
		return $this->popService->destroy($id);
	}
}
