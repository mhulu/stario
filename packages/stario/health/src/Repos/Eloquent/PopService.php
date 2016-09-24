<?php
namespace Star\Health\Repos\Eloquent;

use Illuminate\Support\Collection;
use Illuminate\Http\Response;
use Star\Health\Repos\Contracts\iPop;
use Star\Health\Repos\Contracts\iPopHealthRecord;
use Star\utils\CreateJson;

/**
 * 流动人口操作业务类，用于接收一体机同步数据入库操作
 */
class PopService extends BaseService
{
	public function __construct(iPop $pop, iPopHealthRecord $popResultRepo)
	{
		$this->pop = $pop;
		$this->popResultRepo = $popResultRepo;
	}
	// 必须实现的抽象方法，名称对应上面的构造方法中的$this->{NAME}
	public function model()
	{
		return 'pop';
	}
	/**
	 * 必须实现的抽象方法，用来创建病人病例信息
	 * 存储流动人口上传数据至数据库
	 * @param  array  $data 
	 * @return 固定的webservice接口格式       参见Utils\SoapClass
	 */
	public function create(array $data)
	{
		if (!array_key_exists('jmxx', $data)) {
			return CreateJson::create(406);
		}
		// 居民信息
		$baseInfo = $data['jmxx'];
		// 检查结果
		$healthRecord = collect($data['jcjgs']['item']);
		// 检查数据库中是否存在该身份证号
		$pop = $this->pop->findBy('identify', $baseInfo['sfzh']);
		// 调用处理方法，只获取有意义的数据并合并成一个字符串
		$records = $this->makeHealthRecord($healthRecord);
		// 创建一个PopHealthRecord实例
		$popResultRepo = $this->popResultRepo->create(['result' => $records]);
		// 如果已经存在该身份证号码则只写入检查结果并返回成功标志
		if (!empty($pop)) {
			try {
				$pop->health_record()->save($popResultRepo);
				return $this->responsor();
			} catch (\Exception $e) {
				return $this->responsor(false);
			}
		}
		// 如果没有存在该身份证号码则创建
			$thePop = $this->pop->create([
				'identify' => $baseInfo['sfzh'],
				'password' => substr($baseInfo['sfzh'], -6),
				'name' => $baseInfo['xm'],
				'birthday' => $baseInfo['csrq'],
				'sex' => $baseInfo['xb'],
				'phone' => $baseInfo['lxdh'],
				'address' => $baseInfo['xzz'],
				'check_date' => $baseInfo['jcrq'],
				'check_unit' => $baseInfo['jcjg'],
				'doctor' => $baseInfo['jcys'],
				'memo' => $baseInfo['bz']
			]);
			try {
					$thePop->health_record()->save($popResultRepo);
					return $this->responsor();
				} catch (\Exception $e) {
					return $this->responsor(false);
				}	
	}
	/**
	 * 生成SOAP接口标识
	 */
	private function responsor()
	{
		$options = array('soap_version' => SOAP_1_2, 'uri' => 'http://jd.wemesh.cn/popUpload');
		$soap = new \SoapServer(null, $options);
		$soap->setClass('Star\Health\Utils\SoapClass');

		$response = new Response();
		$response->headers->set('Content-Type','text/xml; charset=utf-8');

		ob_start();
		$soap->handle();
		$response->setContent(ob_get_clean());
		// 必须返回成功标识
		return $response;
	}
	/**
	 * 整理查体结果数据，去掉数据中为false和空的值
	 * 将数据整理成为一个字符串，格式为：
	 * 血压:100,脉搏:100
	 * 日后调取可以用 explode 打散
	 * @param  Collection $collection 传递过来的所有集合
	 * @return  String
	 */
	private function makeHealthRecord (Collection $collection)
	{
		$filtered = $collection->reject(function ($val, $k) {
			return $val['jcjg'] == 'false' || $val['jcjg'] == '';
		});
		$result = '';
		foreach ($filtered as $val) {
			$result .= $val['xmmc']. ':' . $val['jcjg'] . ',';
		}
		return rtrim($result, ',');
		$records = $this->collection->create([
			'result'=>rtrim($result, ',')
		]);
	}
}