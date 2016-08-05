<?php 
namespace Star\rongcloud;

use Star\utils\Http;

/**
 * 融云 Server API 文件 For Laravel 5
 * 根据官方提供的sdk改写，主要是将curl换成Guzzle Http
 * 官方sdk 地址: https://github.com/rongcloud/server-sdk-php-composer
 */

class RongCloud
{
	private $appKey;
	private $appSecret;

	const API_URL = 'https://api.cn.ronghub.com';    //IM服务地址


	public function __construct()
	{
		$this->appKey = config('rongcloud.app_key');
		$this->appSecret = config('rongcloud.app_secret');
	}

	/**
	 * You can use RongCloud::take()->[method]
	 */
	public static function take()
	{
		return new static();
	}

	/**
	 * 用Guzzle Http 获取API的私有方法
	 * @param  string $action 目标地址     
	 * @param  array $params      携带的参数（body）
	 * @param  string $contentType 发送的头类型
	 * @param  string $module      前期只做im，后期会加入sms之类（逻辑已经写进去了）
	 * @param  string $httpMethod  HTTP方法
	 * @return collect              返回结果
	 */
	private function fetch($action, $params, $format = 'json', $contentType = 'urlencoded', $module = 'im', $httpMethod = 'POST')
	{
		switch ($module) {
			case 'im':
				$action = self::API_URL.$action.'.'.$format;
				break;
			case 'sms':
				$action = self::SMS_URL.$action.$format;
			default:
				$action = self::API_URL.$action.'.'.$format;
				break;
		}
		$httpHeader = $this->createHttpHeader();
		if (strtoupper($httpMethod) == 'POST' && strtolower($contentType) == 'urlencoded' ) {
			return Http::request($httpMethod, $action)
						->withHeader($httpHeader)
						->withFormBody($params)
						->send();
		} elseif (strtoupper($httpMethod) =='POST' && strtolower($contentType) =='json') {
			return Http::request($httpMethod, $action)
						->withHeader($httpHeader)
						->withBody($params)
						->send();
		} elseif (strtoupper($httpMethod) == 'GET' && strtolower($contentType) =='urlencoded') {
			return Http::request($httpMethod, $action)
						->withHeader($httpHeader)
						->send();
		}
	}

	//API各方法按照http://www.rongcloud.cn/docs/server.html顺序排列

	/**
     	* API 调用签名规则
     	* @param array $data
     	* @return bool
     	*/
    	private function createHttpHeader() {
        	$nonce = mt_rand();
        	$timeStamp = time();
       		$sign = sha1($this->appSecret.$nonce.$timeStamp);
       		return array (
      			'App-Key' => $this->appKey,
      			'Nonce' => $nonce,
      			'Timestamp' => $timeStamp,
      			'Signature' => $sign,
      		);
    	}
    	// 用户服务: 客户端通过融云 SDK 每次连接服务器时，都需要向服务器提供 Token，以便验证身份
	/**
	 * 获取Token
	 *@param $userId   用户 Id，最大长度 32 字节。是用户在 App 中的唯一标识码，必须保证在同一个 App 内不重复，重复的用户 Id 将被当作是同一用户。
     	 * @param $name     用户名称，最大长度 128 字节。用来在 Push 推送时，或者客户端没有提供用户信息时，显示用户的名称。
     	 * @param $portraitUri  用户头像 URI，最大长度 1024 字节。
     	 * @return json|xml
	 */
	public function getToken($userId, $name, $portraitUri)
	{
		$params = [
			'userId' => $userId,
			'name' => $name,
			'portraitUri' => $portraitUri
		];
		return $this->fetch('/user/getToken', $params);
	}

	/**
	 * 刷新用户信息 方法  
	 * 说明：当您的用户昵称和头像变更时，您的 App Server 应该调用此接口刷新在融云侧保存的用户信息，以便融云发送推送消息的时候，能够正确显示用户信息
	 * @param $userId   用户 Id，最大长度 32 字节。是用户在 App 中的唯一标识码，必须保证在同一个 App 内不重复，重复的用户 Id 将被当作是同一用户。（必传）
     	 * @param string $name  用户名称，最大长度 128 字节。用来在 Push 推送时，显示用户的名称，刷新用户名称后 5 分钟内生效。（可选，提供即刷新，不提供忽略）
     	 * @param string $portraitUri   用户头像 URI，最大长度 1024 字节。用来在 Push 推送时显示。（可选，提供即刷新，不提供忽略）
	 * @return  mixed
	 */
	public function refreshUserInfo($userId, $name = '', $portraitUri = '')
	{
		$params = [
			'userId' => $userId,
			'name' => $name,
			'portraitUri' => $portraitUri
		];
		return $this->fetch('/user/refresh', $params);
	}

	/**
	* 检查用户在线状态 方法
	* 请不要频繁循环调用此接口，而是选择合适的频率和时机调用，此接口设置了一定的频率限制。
	* 调用频率：每秒钟限 100 次
     	* @param $userId    用户 Id。（必传）
     	* @return mixed
	*/
	public function checkUserOnline($userId)
	{
		$params = [
			'userId' => $userId
		];
		return $this->fetch('/user/checkOnline', $params);
	}

	// 用户封禁服务: 当用户违反 App 中的相关规定时，可根据情况对用户进行封禁处理，封禁时间范围由开发者自行设置，用户在封禁期间不能连接融云服务器，封禁期满后将自动解除封禁，也可以通过调用 /user/unblock 方法解除用户封禁，解除后可正常连接融云服务器。
	/**
	 * 封禁用户
	 * @param $userId   用户 Id。（必传）
     	 * @param $minute   封禁时长,单位为分钟，最大值为43200分钟。（必传）
     	 * @return mixed
	 */
	public function blockUser($userId, $minute)
	{
		$params = [
			'userId' => $userId,
			'minute' => $minute
		];
		return $this->fetch('/user/block', $params);
	}

	/**
	 * 解除用户封禁
	 * @param  userId
	 * @return mixed
	 */
	public function unblockUser($userId)
	{
		$params = [
			'userId' => $userId
		];
		return $this->fetch('/user/unblock', $params);
	}

	/**
	* 获取被封禁用户列表
	 * @return mixed
	 */
	public function getBlockedUserList()
	{
		return $this->fetch('/user/block/query', '');
	}

	//用户黑名单服务：在 App 中如果用户不想接收到某一用户的消息或不想被某一用户联系到时，可将此用户加入到黑名单中，应用中的每个用户都可以设置自已的黑名单列表。
	/**
	* 添加用户到黑名单 方法
     	* @param $userId       用户 Id。（必传）
     	* @param $blackUserId  被拉黑的用户Id。(必传)
     	* @return mixed
	*/
	public function addUserToBlackList($userId, $blackUserId = [])
	{
		$params = [
			'userId' => $userId,
			'blackUserId' => $blackUserId
		];
		return $this->fetch('/user/blacklist/add', $params);
	}

	/**
	 * 从黑名单中移除用户 方法
	 * @param  $userId               用户 Id。（必传）
	 * @param array $blackUserId    被移除的用户Id。(必传)
	 * @return mixed
	 */
	public function removeUserFromBlackList($userId, $blackUserId = array ())
	{
		$params = [
			'userId' => $userId,
			'blackUserId' => $blackUserId
		];
		return $this->fetch('/user/blacklist/remove', $params);
	}	

	/**
	 * 获取某个用户的黑名单列表
     	 * @param $userId   用户 Id。（必传）
	 * @return mixed
	 */
	public function getBlackList($userId)
	{
		$params = [
			'userId' => $userId
		];
		return $this->fetch('/user/blacklist/query', $params);
	}	

	//消息发送服务：融云的内置消息以 JSON 方式进行数据序列化，如果你需要扩展消息可以使用任意方式扩展，不限于 JSON，参考http://www.rongcloud.cn/docs/server.html#消息发送服务
	 /**
	 * 发送会话消息
     	 * @param $fromUserId   发送人用户 Id。（必传）
     	 * @param $toUserId     接收用户 Id，提供多个本参数可以实现向多人发送消息。（必传）
     	 * @param $objectName   消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     	 * @param $content      发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     	 * @param string $pushContent   如果为自定义消息，定义显示的 Push 内容。(可选)
     	 * @param string $pushData  针对 iOS 平台，Push 通知附加的 payload 字段，字段名为 appData。(可选)
     	 * @return json|xml
	 */
	public function sendPrivateMessage($fromUserId, $toUserId = array(), $objectName, $content, $pushContent='', $pushData = '')
	{
		$params = array(
	                'fromUserId'=>$fromUserId,
	                'objectName'=>$objectName,
	                'content'=>$content,
	                'pushContent'=>$pushContent,
	                'pushData'=>$pushData,
	                'toUserId' => $toUserId
            	);
		return $this->fetch('/message/private/publish', $params);
	}

	/**
	* @param $fromUserId   发送人用户 Id。（必传）
     	* @param $toUserId     接收用户 Id，提供多个本参数可以实现向多人发送消息。（必传）
     	* @param $objectName   消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     	* @param $values       消息内容中，标识位对应内容。（必传）
     	* @param $content      发送消息内容，内容中定义标识通过 values 中设置的标识位内容进行替换，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     	* @param string $pushContent   如果为自定义消息，定义显示的 Push 内容。(可选)
     	* @param string $pushData  针对 iOS 平台，Push 通知附加的 payload 字段，字段名为 appData。(可选)
     	* @param $verifyBlacklist   是否过滤发送人黑名单列表，0 为不过滤、 1 为过滤，默认为 0 不过滤。(可选)
     	* @return json|xml
	*/
	public function sendPrivateMessageByTemplate($fromUserId, array $toUserId, $objectName, $values, $content, $pushContent = '', $pushData = '', $verifyBlacklist = 0)
	{
		$params = [
		     'fromUserId' => $fromUserId,
                    'toUserId' => $toUserId,
                    'objectName' => $objectName,
                    'values' => $values,
                    'content' => $content,
                    'pushContent' => $pushContent,
                    'pushData' => $pushData,
                    'verifyBlacklist' => $verifyBlacklist,
		];

		return $this->fetch('/message/private/publish_template', $params, 'json');
	}

	/**
	* 发送系统模板消息 方法
     	* @param $fromUserId   发送人用户 Id。（必传）
     	* @param $toUserId     接收用户 Id，提供多个本参数可以实现向多人发送消息。（必传）
     	* @param $objectName   消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     	* @param $values       消息内容中，标识位对应内容。（必传）
     	* @param $content      发送消息内容，内容中定义标识通过 values 中设置的标识位内容进行替换，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     	* @param string $pushContent   如果为自定义消息，定义显示的 Push 内容。(可选)
     	* @param string $pushData  针对 iOS 平台，Push 通知附加的 payload 字段，字段名为 appData。(可选)
     	* @return json|xml
	 */
	public function sendSystemMessageByTemplate($fromUserId, array $toUserId, $objectName, $values, $content, $pushContent = '', $pushData = '')
	{
		$params = [
			'fromUserId' => $fromUserId,
                    	'toUserId' => $toUserId,
                    	'objectName' => $objectName,
                    	'values' => $values,
                    	'content' => $content,
                    	'pushContent' => $pushContent,
                    	'pushData' => $pushData,
		];
		return $this->fetch('/message/system/publish_template', $params, 'json');
	}

	/**
	 * 以一个用户身份向群组发送消息
     	 * @param $fromUserId           发送人用户 Id。（必传）
     	 * @param $toGroupId             接收群Id，提供多个本参数可以实现向多群发送消息。（必传）
     	 * @param $objectName           消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     	 * @param $content              发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     	 * @param string $pushContent   如果为自定义消息，定义显示的 Push 内容。(可选)
     	 * @param string $pushData      针对 iOS 平台，Push 通知附加的 payload 字段，字段名为 appData。(可选)
     	 * @return json|xml
	 */
	public function sendGroupMessage($fromUserId, $toGroupId = array(), $objectName, $content, $pushContent='', $pushData = '')
	{
		$params = [
			'fromUserId' => $fromUserId,
                	'objectName' => $objectName,
                	'content' => $content,
                	'pushContent' => $pushContent,
                	'pushData' => $pushData,
                	'toGroupId' => $toGroupId
		];
		$this->fetch('/message/group/publish', $params);
	}

	/**
	* 一个用户向聊天室发送消息
     	* @param $fromUserId               发送人用户 Id。（必传）
     	* @param $toChatroomId             接收聊天室Id，提供多个本参数可以实现向多个聊天室发送消息。（必传）
     	* @param $objectName               消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     	* @param $content                  发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     	* @return json|xml
	*/
	public function sendChatroomMessage($fromUserId, $toChatroomId = array(), $objectName, $content)
	{
		$params = [
			'fromUserId' => $fromUserId,
                	'objectName' => $objectName,
                	'content' => $content,
                	'toChatroomId' => $toChatroomId
		];
		$this->fetch('/message/chatroom/publish', $params);
	}

	/**
	* 发送讨论组消息
     	* @param $fromUserId               发送人用户 Id。（必传）
     	* @param $toDiscussionId             接收讨论组 Id。（必传）
     	* @param $objectName               消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     	* @param $content                  发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     	* @param string $pushContent   如果为自定义消息，定义显示的 Push 内容。(可选)
     	* @param string $pushData  针对 iOS 平台，Push 通知附加的 payload 字段，字段名为 appData。(可选)
     	* @return json|xml 
	*/
	public function sendDiscussionMessage($fromUserId, $toDiscussionId, $objectName, $content, $pushContent = '', $pushData = '')
	{
		$params = [
			'fromUserId' => $fromUserId,
                    	'toDiscussionId' => $toDiscussionId,
                    	'objectName' => $objectName,
                    	'content' => $content,
                    	'pushContent' => $pushContent,
                    	'pushData' => $pushData
		];
		return $this->fetch('/message/discussion/publish', $params);
	}

	/**
	* 一个用户向一个或多个用户发送系统消息
	* @param $fromUserId       发送人用户 Id。（必传）
     	* @param $toUserId         接收用户Id，提供多个本参数可以实现向多用户发送系统消息。（必传）
     	* @param $objectName       消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     	* @param $content          发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     	* @param string $pushContent   如果为自定义消息，定义显示的 Push 内容。(可选)
     	* @param string $pushData  针对 iOS 平台，Push 通知附加的 payload 字段，字段名为 appData。(可选)
     	* @return json|xml
	*/
	public function sendSystemMessage($fromUserId, $toUserId = array (), $objectName, $content, $pushContent = '', $pushData = '')
	{
		$params = [
			'fromUserId' => $fromUserId,
                	'objectName' => $objectName,
                	'content' => $content,
                	'pushContent' => $pushContent,
                	'pushData' => $pushData,
                	'toUserId' => $toUserId
		];
		return $this->fetch('/message/system/publish', $params);
	}

	/**
	* 某发送消息给一个应用下的所有注册用户。
     	* @param $fromUserId       发送人用户 Id。（必传）
     	* @param $objectName       消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     	* @param $content          发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     	* @return json|xml
	*/
	public function sendBroadcastMessage($fromUserId, $objectName, $content)
	{
		$params = [
			'fromUserId' => $fromUserId,
                    	'objectName' => $objectName,
                    	'content' => $content
		];
		return $this->fetch('/message/broadcast', $params);
	}

	/**
	* 获取 APP 内指定某天某小时内的所有会话消息记录的下载地址
     	* @param $date     指定北京时间某天某小时，格式为：2014010101,表示：2014年1月1日凌晨1点。（必传）
     	* @return json|xml
	*/
	public function getMessageHistory($date)
	{
		$params = [
			'date' => $date
		];
		$this->fetch('/message/history', $params);
	}

	/**
	* 删除 APP 内指定某天某小时内的所有会话消息记录
     	* @param $date     指定北京时间某天某小时，格式为：2014010101,表示：2014年1月1日凌晨1点。（必传）
     	* @return json|xml
	*/
	public function deleteMessageHistory($date)
	{
		$params = [
			'date' => $date
		];
		$this->fetch('/message/history/delete', $params);
	}

	/**
	* 向融云服务器提交 userId 对应的用户当前所加入的所有群组。
     	* @param $userId           被同步群信息的用户Id。（必传）
     	* @param array $data       该用户的群信息。（必传）array('key'=>'val')
     	* @return json|xml
	*/
	public function syncGroup($userId, $data = array())
	{
		$arrKey = array_keys($data);
            	$arrVal = array_values($data);
            	$params = [
            		'userId' => $userId
            	];
            	foreach ($data as $key => $value) {
            		$params['group[' . $key . ']'] = $value;
            	}
            	return $this->fetch('/group/sync', $params);
	}

	/**
	* 将用户加入指定群组，用户将可以收到该群的消息。
     	* @param $userId           要加入群的用户 Id。（必传）
     	* @param $groupId          要加入的群 Id。（必传）
     	* @param $groupName        要加入的群 Id 对应的名称。（必传）
     	* @return json|xml
	*/
	public function joinGroup($userId, $groupId, $groupName)
	{
		$params = [
			'userId' => $userId,
                    	'groupId' => $groupId,
                    	'groupName' => $groupName
		];
		return $this->fetch('/group/join', $params);
	}

	/**
	* 将用户从群中移除，不再接收该群组的消息。
     	* @param $userId       要退出群的用户 Id。（必传）
     	* @param $groupId      要退出的群 Id。（必传）
     	* @return mixed
	*/
	public function removeUserFromGroup($userId, $groupId)
	{
		$params = [
			'userId' => $userId,
			'groupId' => $groupId
		];
		return $this->fetch('/group/quit', $params);
	}

	/**
	* 解散群组方法  将该群解散，所有用户都无法再接收该群的消息。
     	* @param $userId           操作解散群的用户 Id。（必传）
     	* @param $groupId          要解散的群 Id。（必传）
     	* @return mixed
     	*/
	public function dismissGroup($userId, $groupId)
	{
		$params = [
			'userId' => $userId,
			'groupId' => $groupId
		];
		return $this->fetch('/group/dismiss', $params);
	}

	/**
	* 创建群组，并将用户加入该群组，用户将可以收到该群的消息。注：其实本方法是加入群组方法 /group/join 的别名。
     	* @param $userId       要加入群的用户 Id。（必传）
     	* @param $groupId      要加入的群 Id。（必传）
     	* @param $groupName    要加入的群 Id 对应的名称。（可选）
     	* @return json|xml
	 */
	public function createGroup($userId, $groupId, $groupName)
	{
		$params = [
			'userId' => $userId,
			'groupId' => $groupId,
			'groupName' = $groupName
		];
		return $this->fetch('/group/create', $params);
	}

	/**
	* 查询群成员 方法
     	* @param $groupId      群 Id。（必传）
     	* @return json|xml
	*/
	public function getGroupUsers($groupId)
	{
		$params = [
			'groupId' => $groupId
		];
		return $this->fetch('/group/user/query', $params);
	}

	/**
	* 创建聊天室
     	* @param array $data   key:要创建的聊天室的id；val:要创建的聊天室的name。（必传）
     	* @return json|xml
	*/
	public function createChatroom($data = [])
	{
		$params = array ();
		foreach ($data as $key => $value) {
			$k = 'chatroom['. $key . ']';
                	$params["$k"] = $val;
		}
		return $this->fetch('/chatroom/create', $params);
	}

	/**
	* 加入聊天室
     	* @param array $userId   要加入聊天室的用户 Id，可提交多个，最多不超过 50 个。（必传）
     	* @param array $chatroomId   要加入的聊天室 Id。（必传）
     	* @return json|xml
	*/
	public function joinChatroom(array $userId, $chatroomId)
	{
		$params = [
			'userId' => $userId,
			'chatroomId' => $chatroomId
		];
		return $this->fetch('/chatroom/join', $params);
	}

	/**
	* 查询聊天室信息 方法
     	* @param $chatroomId   要查询的聊天室id（必传）
     	* @return json|xml
	*/
	public function findChatroom($chatroomId)
	{
		$params = [
			'chatroomId' => $chatroomId
		];
		return $this->fetch('/chatroom/query', $params);
	}

	/**
     	* 销毁聊天室
     	* @param $chatroomId   要销毁的聊天室 Id。（必传）
     	* @return json|xml
     	*/
	public function destroyChatroom($chatroomId)
	{
		$params = [
			'chatroomId' => $chatroomId
		];
		return $this->fetch('/chatroom/destroy', $params);
	}

	/**
     	* 聊天室消息停止分发 方法
     	* @param $chatroomId   要查询的聊天室id（必传）
     	* @return json|xml
     	*/
	public function suspendChatroom($chatroomId)
	{
		$params = [
			'chatroomId' => $chatroomId
		];
		return $this->fetch('/chatroom/message/stopDistribution', $params);
	}

	/**
     	* 聊天室消息恢复分发 方法
     	* @param $chatroomId   要查询的聊天室id（必传）
     	* @return json|xml
     	*/
	public function resumeChatroom($chatroomId)
	{
		$params = [
			'chatroomId' => $chatroomId
		];
		return $this->fetch('/chatroom/message/resumeDistribution', $params);
	}

	/**
     	* 查询聊天室内用户
     	* @param $chatroomId  聊天室 Id
     	* @param $count       要获取的聊天室成员数，上限为 500 ，超过 500 时最多返回 500 个成员（必传）
     	* @param $order       加入聊天室的先后顺序， 1 为加入时间正序， 2 为加入时间倒序（必传）
     	*/
	public function findChatroomUsers($chatroomId, $count = 500, $order = 1)
	{
		$params = [
			'chatroomId' => $chatroomId,
			'count' => $count,
			'order' => $order
		];
		return $this->fetch('/chatroom/user/query', $params);
	}



	/**
	*添加禁言群成员
	*@param $userId   用户 Id。（必传）
     	* @param $groupId 群组 Id。（必传）
     	* @param $minute 禁言时长，以分钟为单位，可以不传此参数，默认为永久禁言。
     	* @return mixed
	*/
	public function muteGroupUser($userId, $groupId, $minute)
	{
		$params = [
			'userId' => $userId,
			'groupId' => $groupId,
			'minute' => $minute
		];
		return $this->fetch('/group/user/gag/add', $params);
	}

	/**
	 * 移除禁言群成员
	 * @param  $userId  用户 Id（必传）
	 * @param  $groupId  群组 Id （必传）
	 * @return mixed
	 */
	public function unMuteGroupUser($userId, $groupId)
	{
		$params = [
			'$userId' => $userId,
			'groupId' => $groupId
		];
		return $this->fetch('/group/user/gag/rollback', $params);
	}

	/**
	 * 查询被禁言群成员
	 * @param  $groupId
	 * @return mixed
	 */
	public function getGroupMutedList($groupId)
	{
		$params = [
			'groupId' => $groupId
		];
		return $this->fetch('/group/user/gag/list', $params);
	}

	/**
	 * 添加敏感词
	 * @param $word 敏感词，最长不超过 32 个字符。（必传）
	 * @return mixed 
	 */
	public function addWordFilter($word)
	{
		$params = [
			'word' => $word
		];
		return $this->fetch('/wordfilter/add', $params);
	}

	/**
	 * 移除敏感词
	 * @param  $word 敏感词，最长不超过 32 个字符。（必传）
	 * @return mixed
	 */
	public function deleteWordFilter($word)
	{
		$params = [
			'word' => $word
		];
		return $this->fetch('/wordfilter/delete', $params);
	}

	/**
	 * 查询敏感词列表
	 * @return mixed
	 */
	public function getWordFilterList()
	{
		return $this->fetch('/wordfilter/list', array ());
	}

	/**
	 * 聊天室成员禁言
	 * @param  $userId 用户 Id。（必传）
	 * @param  $chatroomId 聊天室 Id。（必传）
	 * @param  $minute 禁言时长，以分钟为单位，最大值为43200分钟。（必传）
	 * @return mixed
	 */
	public function muteChatroomUser($userId, $chatroomId, $minute)
	{
		$params = [
			'userId' => $userId,
			'chatroomId' => $chatroomId,
			'minute' => $minute
		];
		return $this->fetch('/chatroom/user/gag/add', $params);
	}

	/**
	 * 移除聊天室成员禁言
	 * @param  $userId
	 * @param $chatroomId 
	 * @return  mixed
	 */
	public function unMuteChatroomUser($userId, $chatroomId)
	{
		$params = [
			'userId' => $userId,
			'chatroomId' => $chatroomId
		];
		return $this->fetch('/chatroom/user/gag/rollback', $params);
	}

	/**
	 * 获取聊天室已禁言用户列表
	 * @param  $chatroomId
	 * @return mixed
	 */
	public function getChatroomMutedList($chatroomId)
	{
		$params = [
			'chatroomId' => $chatroomId
		];
		return $this->fetch('/chatroom/user/gag/list', $params);
	}

	/**
	 * 封禁聊天室用户
	 * @param  $userId
	 * @param  $chatroomId
	 * @param  $minute
	 * @return mixed
	 */
	public function blockChatroomUser($userId, $chatroomId, $minute)
	{
		$params = [
			'userId' => $userId,
			'chatroomId' => $chatroomId,
			'minute' => $minute
		];
		return $this->fetch('/chatroom/user/block/add', $params);
	}

	/**
	 * 解除聊天室用户封禁
	 * @param  $userId
	 * @param  $chatroomId
	 * @return mixed
	 */
	public function unblockChatroomUser($userId, $chatroomId)
	{
		$params = [
			'userId' => $userId,
			'chatroomId' => $chatroomId
		];
		return $this->fetch('/chatroom/user/block/rollback', $params);
	}

	/**
	 * 获取聊天室被封禁用户列表
	 * @param  chatroomId
	 * @return mixed
	 */
	public function getChatroomBlockedList($chatroomId)
	{
		$params = [
			'chatroomId' => $chatroomId
		];
		return $this->fetch('/chatroom/user/block/list', $params);
	}
}