<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Star\utils\Serializer;

class TestController extends Controller
{
    public function server()
    {

                $rawPostData = '<v:Envelope xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns:d="http://www.w3.org/2001/XMLSchema" xmlns:c="http://www.w3.org/2003/05/soap-encoding" xmlns:v="http://www.w3.org/2003/05/soap-envelope"><v:Header /><v:Body><getUpload xmlns="http://qdsdo/" id="o0" c:root="1"><dataXML i:type="d:string">&lt;?xml version="1.0" encoding="UTF-8"?&gt;&lt;jcdata&gt;&lt;jmxx&gt;&lt;sfzh&gt;450303198807073322&lt;/sfzh&gt;&lt;xm&gt;&#24352;&#19977;&lt;/xm&gt;&lt;csrq&gt;1988-07-07&lt;/csrq&gt;&lt;xb&gt;&#22899;&lt;/xb&gt;&lt;lxdh&gt;&lt;/lxdh&gt;&lt;xzz&gt;&lt;/xzz&gt;&lt;jcbh&gt;fbc5f0fd-8f73-4732-ab37-dbf28ad9509d&lt;/jcbh&gt;&lt;jcrq&gt;2016-08-25&lt;/jcrq&gt;&lt;jcjg&gt;&#27979;&#35797;&#26426;&#26500;&lt;/jcjg&gt;&lt;jcys&gt;&#27979;&#35797;&#21307;&#29983;&lt;/jcys&gt;&lt;bz&gt;&lt;/bz&gt;&lt;/jmxx&gt;&lt;jcjgs&gt;&lt;item id="1"&gt;&lt;xmbh&gt;10001&lt;/xmbh&gt;&lt;xmmc&gt;&#26080;&#30151;&#29366;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="2"&gt;&lt;xmbh&gt;10002&lt;/xmbh&gt;&lt;xmmc&gt;&#22836;&#30171;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="3"&gt;&lt;xmbh&gt;10003&lt;/xmbh&gt;&lt;xmmc&gt;&#22836;&#26197;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="4"&gt;&lt;xmbh&gt;10004&lt;/xmbh&gt;&lt;xmmc&gt;&#24515;&#24760;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="5"&gt;&lt;xmbh&gt;10005&lt;/xmbh&gt;&lt;xmmc&gt;&#33016;&#38391;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="6"&gt;&lt;xmbh&gt;10006&lt;/xmbh&gt;&lt;xmmc&gt;&#33016;&#30171;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="7"&gt;&lt;xmbh&gt;10007&lt;/xmbh&gt;&lt;xmmc&gt;&#24930;&#24615;&#21683;&#22013;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="8"&gt;&lt;xmbh&gt;10008&lt;/xmbh&gt;&lt;xmmc&gt;&#21683;&#30192;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="9"&gt;&lt;xmbh&gt;10009&lt;/xmbh&gt;&lt;xmmc&gt;&#21628;&#21560;&#22256;&#38590;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="10"&gt;&lt;xmbh&gt;10010&lt;/xmbh&gt;&lt;xmmc&gt;&#22810;&#39278;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="11"&gt;&lt;xmbh&gt;10011&lt;/xmbh&gt;&lt;xmmc&gt;&#22810;&#23615;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="12"&gt;&lt;xmbh&gt;10012&lt;/xmbh&gt;&lt;xmmc&gt;&#20307;&#37325;&#19979;&#38477;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="13"&gt;&lt;xmbh&gt;10013&lt;/xmbh&gt;&lt;xmmc&gt;&#20047;&#21147;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="14"&gt;&lt;xmbh&gt;10014&lt;/xmbh&gt;&lt;xmmc&gt;&#20851;&#33410;&#32959;&#30171;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="15"&gt;&lt;xmbh&gt;10015&lt;/xmbh&gt;&lt;xmmc&gt;&#35270;&#21147;&#27169;&#31946;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="16"&gt;&lt;xmbh&gt;10016&lt;/xmbh&gt;&lt;xmmc&gt;&#25163;&#33050;&#40635;&#26408;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="17"&gt;&lt;xmbh&gt;10017&lt;/xmbh&gt;&lt;xmmc&gt;&#23615;&#24613;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="18"&gt;&lt;xmbh&gt;10018&lt;/xmbh&gt;&lt;xmmc&gt;&#23615;&#30171;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="19"&gt;&lt;xmbh&gt;10019&lt;/xmbh&gt;&lt;xmmc&gt;&#20415;&#31192;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="20"&gt;&lt;xmbh&gt;10020&lt;/xmbh&gt;&lt;xmmc&gt;&#33145;&#27899;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="21"&gt;&lt;xmbh&gt;10021&lt;/xmbh&gt;&lt;xmmc&gt;&#24694;&#24515;&#21589;&#21520;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="22"&gt;&lt;xmbh&gt;10022&lt;/xmbh&gt;&lt;xmmc&gt;&#30524;&#33457;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="23"&gt;&lt;xmbh&gt;10023&lt;/xmbh&gt;&lt;xmmc&gt;&#32819;&#40483;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="24"&gt;&lt;xmbh&gt;10024&lt;/xmbh&gt;&lt;xmmc&gt;&#20083;&#25151;&#32960;&#30171;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="25"&gt;&lt;xmbh&gt;10025&lt;/xmbh&gt;&lt;xmmc&gt;&#20854;&#20182;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="26"&gt;&lt;xmbh&gt;10101&lt;/xmbh&gt;&lt;xmmc&gt;&#20307;&#28201;&lt;/xmmc&gt;&lt;jcjg&gt;36.5&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="27"&gt;&lt;xmbh&gt;10102&lt;/xmbh&gt;&lt;xmmc&gt;&#33033;&#29575;&lt;/xmmc&gt;&lt;jcjg&gt;78&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="28"&gt;&lt;xmbh&gt;10103&lt;/xmbh&gt;&lt;xmmc&gt;&#21628;&#21560;&#39057;&#29575;&lt;/xmmc&gt;&lt;jcjg&gt;21&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="29"&gt;&lt;xmbh&gt;10104&lt;/xmbh&gt;&lt;xmmc&gt;&#24038;&#20391;&#25910;&#32553;&#21387;&lt;/xmmc&gt;&lt;jcjg&gt;144&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="30"&gt;&lt;xmbh&gt;10105&lt;/xmbh&gt;&lt;xmmc&gt;&#24038;&#20391;&#33298;&#24352;&#21387;&lt;/xmmc&gt;&lt;jcjg&gt;87&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="31"&gt;&lt;xmbh&gt;10108&lt;/xmbh&gt;&lt;xmmc&gt;&#36523;&#39640;&lt;/xmmc&gt;&lt;jcjg&gt;177&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="32"&gt;&lt;xmbh&gt;10109&lt;/xmbh&gt;&lt;xmmc&gt;&#20307;&#37325;&lt;/xmmc&gt;&lt;jcjg&gt;65&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="33"&gt;&lt;xmbh&gt;10111&lt;/xmbh&gt;&lt;xmmc&gt;&#20307;&#36136;&#25351;&#25968;&lt;/xmmc&gt;&lt;jcjg&gt;20.75&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="34"&gt;&lt;xmbh&gt;10401&lt;/xmbh&gt;&lt;xmmc&gt;&#33636;&#32032;&#22343;&#34913;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="35"&gt;&lt;xmbh&gt;10402&lt;/xmbh&gt;&lt;xmmc&gt;&#33636;&#39135;&#20026;&#20027;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="36"&gt;&lt;xmbh&gt;10403&lt;/xmbh&gt;&lt;xmmc&gt;&#32032;&#39135;&#20026;&#20027;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="37"&gt;&lt;xmbh&gt;10404&lt;/xmbh&gt;&lt;xmmc&gt;&#21980;&#30416;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="38"&gt;&lt;xmbh&gt;10405&lt;/xmbh&gt;&lt;xmmc&gt;&#21980;&#27833;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="39"&gt;&lt;xmbh&gt;10406&lt;/xmbh&gt;&lt;xmmc&gt;&#21980;&#31958;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="40"&gt;&lt;xmbh&gt;10601&lt;/xmbh&gt;&lt;xmmc&gt;&#30333;&#37202;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="41"&gt;&lt;xmbh&gt;10602&lt;/xmbh&gt;&lt;xmmc&gt;&#21860;&#37202;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="42"&gt;&lt;xmbh&gt;10603&lt;/xmbh&gt;&lt;xmmc&gt;&#32418;&#37202;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="43"&gt;&lt;xmbh&gt;10604&lt;/xmbh&gt;&lt;xmmc&gt;&#40644;&#37202;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="44"&gt;&lt;xmbh&gt;10605&lt;/xmbh&gt;&lt;xmmc&gt;&#20854;&#20182;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="45"&gt;&lt;xmbh&gt;12201&lt;/xmbh&gt;&lt;xmmc&gt;&#20083;&#33146;&#26410;&#35265;&#24322;&#24120;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="46"&gt;&lt;xmbh&gt;12202&lt;/xmbh&gt;&lt;xmmc&gt;&#20083;&#33146;&#20083;&#25151;&#20999;&#38500;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="47"&gt;&lt;xmbh&gt;12203&lt;/xmbh&gt;&lt;xmmc&gt;&#20083;&#33146;&#24322;&#24120;&#27852;&#20083;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="48"&gt;&lt;xmbh&gt;12204&lt;/xmbh&gt;&lt;xmmc&gt;&#20083;&#33146;&#20083;&#33146;&#21253;&#22359;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="49"&gt;&lt;xmbh&gt;12205&lt;/xmbh&gt;&lt;xmmc&gt;&#20083;&#33146;&#20854;&#20182;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="50"&gt;&lt;xmbh&gt;14101&lt;/xmbh&gt;&lt;xmmc&gt;&#33041;&#34880;&#31649;&#30142;&#30149;&#26410;&#21457;&#29616;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="51"&gt;&lt;xmbh&gt;14102&lt;/xmbh&gt;&lt;xmmc&gt;&#33041;&#34880;&#31649;&#30142;&#30149;&#32570;&#34880;&#24615;&#21330;&#20013;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="52"&gt;&lt;xmbh&gt;14103&lt;/xmbh&gt;&lt;xmmc&gt;&#33041;&#34880;&#31649;&#30142;&#30149;&#33041;&#20986;&#34880;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="53"&gt;&lt;xmbh&gt;14104&lt;/xmbh&gt;&lt;xmmc&gt;&#33041;&#34880;&#31649;&#30142;&#30149;&#34523;&#32593;&#33180;&#19979;&#33108;&#20986;&#34880;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="54"&gt;&lt;xmbh&gt;14105&lt;/xmbh&gt;&lt;xmmc&gt;&#33041;&#34880;&#31649;&#30142;&#30149;&#30701;&#26242;&#24615;&#33041;&#32570;&#34880;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="55"&gt;&lt;xmbh&gt;14106&lt;/xmbh&gt;&lt;xmmc&gt;&#33041;&#34880;&#31649;&#30142;&#30149;&#20854;&#20182;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="56"&gt;&lt;xmbh&gt;14201&lt;/xmbh&gt;&lt;xmmc&gt;&#32958;&#33039;&#30142;&#30149;&#26410;&#21457;&#29616;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="57"&gt;&lt;xmbh&gt;14202&lt;/xmbh&gt;&lt;xmmc&gt;&#32958;&#33039;&#30142;&#30149;&#31958;&#23615;&#30149;&#32958;&#30149;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="58"&gt;&lt;xmbh&gt;14203&lt;/xmbh&gt;&lt;xmmc&gt;&#32958;&#33039;&#30142;&#30149;&#32958;&#21151;&#33021;&#34928;&#31469;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="59"&gt;&lt;xmbh&gt;14204&lt;/xmbh&gt;&lt;xmmc&gt;&#32958;&#33039;&#30142;&#30149;&#24613;&#24615;&#32958;&#28814;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="60"&gt;&lt;xmbh&gt;14205&lt;/xmbh&gt;&lt;xmmc&gt;&#32958;&#33039;&#30142;&#30149;&#24930;&#24615;&#32958;&#28814;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="61"&gt;&lt;xmbh&gt;14206&lt;/xmbh&gt;&lt;xmmc&gt;&#32958;&#33039;&#30142;&#30149;&#20854;&#20182;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="62"&gt;&lt;xmbh&gt;14301&lt;/xmbh&gt;&lt;xmmc&gt;&#24515;&#33039;&#30142;&#30149;&#26410;&#21457;&#29616;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="63"&gt;&lt;xmbh&gt;14302&lt;/xmbh&gt;&lt;xmmc&gt;&#24515;&#33039;&#30142;&#30149;&#24515;&#32908;&#26775;&#27515;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="64"&gt;&lt;xmbh&gt;14303&lt;/xmbh&gt;&lt;xmmc&gt;&#24515;&#33039;&#30142;&#30149;&#24515;&#32478;&#30171;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="65"&gt;&lt;xmbh&gt;14304&lt;/xmbh&gt;&lt;xmmc&gt;&#24515;&#33039;&#30142;&#30149;&#20896;&#29366;&#21160;&#33033;&#34880;&#36816;&#37325;&#24314;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="66"&gt;&lt;xmbh&gt;14305&lt;/xmbh&gt;&lt;xmmc&gt;&#24515;&#33039;&#30142;&#30149;&#20805;&#34880;&#24615;&#24515;&#21147;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="67"&gt;&lt;xmbh&gt;14306&lt;/xmbh&gt;&lt;xmmc&gt;&#24515;&#33039;&#30142;&#30149;&#24515;&#21069;&#21306;&#30140;&#30171;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="68"&gt;&lt;xmbh&gt;14307&lt;/xmbh&gt;&lt;xmmc&gt;&#24515;&#33039;&#30142;&#30149;&#20854;&#20182;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="69"&gt;&lt;xmbh&gt;14401&lt;/xmbh&gt;&lt;xmmc&gt;&#34880;&#31649;&#30142;&#30149;&#26410;&#21457;&#29616;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="70"&gt;&lt;xmbh&gt;14402&lt;/xmbh&gt;&lt;xmmc&gt;&#34880;&#31649;&#30142;&#30149;&#22841;&#23618;&#21160;&#33033;&#30244;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="71"&gt;&lt;xmbh&gt;14403&lt;/xmbh&gt;&lt;xmmc&gt;&#34880;&#31649;&#30142;&#30149;&#21160;&#33033;&#38381;&#22622;&#24615;&#30142;&#30149;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="72"&gt;&lt;xmbh&gt;14404&lt;/xmbh&gt;&lt;xmmc&gt;&#34880;&#31649;&#30142;&#30149;&#20854;&#20182;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="73"&gt;&lt;xmbh&gt;14501&lt;/xmbh&gt;&lt;xmmc&gt;&#30524;&#37096;&#30142;&#30149;&#26410;&#21457;&#29616;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="74"&gt;&lt;xmbh&gt;14502&lt;/xmbh&gt;&lt;xmmc&gt;&#30524;&#37096;&#30142;&#30149;&#35270;&#32593;&#33180;&#20986;&#34880;&#25110;&#28183;&#20986;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="75"&gt;&lt;xmbh&gt;14503&lt;/xmbh&gt;&lt;xmmc&gt;&#30524;&#37096;&#30142;&#30149;&#35270;&#20083;&#22836;&#27700;&#32959;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="76"&gt;&lt;xmbh&gt;14504&lt;/xmbh&gt;&lt;xmmc&gt;&#30524;&#37096;&#30142;&#30149;&#30333;&#20869;&#38556;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="77"&gt;&lt;xmbh&gt;14505&lt;/xmbh&gt;&lt;xmmc&gt;&#30524;&#37096;&#30142;&#30149;&#20854;&#20182;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="78"&gt;&lt;xmbh&gt;15001&lt;/xmbh&gt;&lt;xmmc&gt;&#32435;&#20837;&#24930;&#24615;&#30149;&#24739;&#32773;&#20581;&#24247;&#31649;&#29702;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="79"&gt;&lt;xmbh&gt;15002&lt;/xmbh&gt;&lt;xmmc&gt;&#24314;&#35758;&#22797;&#26597;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="80"&gt;&lt;xmbh&gt;15003&lt;/xmbh&gt;&lt;xmmc&gt;&#24314;&#35758;&#36716;&#35786;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="81"&gt;&lt;xmbh&gt;15101&lt;/xmbh&gt;&lt;xmmc&gt;&#21361;&#38505;&#22240;&#32032;&#25511;&#21046;&#25106;&#28895;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="82"&gt;&lt;xmbh&gt;15102&lt;/xmbh&gt;&lt;xmmc&gt;&#20581;&#24247;&#39278;&#37202;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="83"&gt;&lt;xmbh&gt;15103&lt;/xmbh&gt;&lt;xmmc&gt;&#39278;&#39135;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="84"&gt;&lt;xmbh&gt;15104&lt;/xmbh&gt;&lt;xmmc&gt;&#38203;&#28860;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="85"&gt;&lt;xmbh&gt;15105&lt;/xmbh&gt;&lt;xmmc&gt;&#20943;&#20307;&#37325;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="86"&gt;&lt;xmbh&gt;15106&lt;/xmbh&gt;&lt;xmmc&gt;&#24314;&#35758;&#25509;&#31181;&#30123;&#33495;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;item id="87"&gt;&lt;xmbh&gt;15107&lt;/xmbh&gt;&lt;xmmc&gt;&#20854;&#20182;&lt;/xmmc&gt;&lt;jcjg&gt;false&lt;/jcjg&gt;&lt;/item&gt;&lt;/jcjgs&gt;&lt;/jcdata&gt;</dataXML></getUpload></v:Body></v:Envelope>';
                // if ($rawPostData = file_get_contents("php://input")) {
                //     Log::info($rawPostData);
                // }
                // $options = array('soap_version' => SOAP_1_2, 'uri' => 'http://jd.wemesh.cn/test');
                // $soap = new \SoapServer(null, $options);
                // $soap->setClass('App\SoapClass');

                // $response = new Response();
                // $response->headers->set('Content-Type','text/xml; charset=utf-8');

                // ob_start();
                // $soap->handle();
                // $response->setContent(ob_get_clean());

                // return $response;

    	$result = Serializer::xmlDecode($rawPostData);
    	$data = $result['v:Body']['getUpload']['dataXML']['#'];
        return Serializer::parse($data);
    }
}
