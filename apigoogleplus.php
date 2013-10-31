<?php


$gPlusRecoveryEmail = "";
$gPlusRecoveryPhone = "";
if (!(function_exists("prr")))
{
	function prr($str) {

		echo "<pre>";
		print_r($str);
		echo "</pre>\r
";
		return;
	};
}
if (!(function_exists("cutfromto")))
{
	function cutfromto($string, $from, $to) {

		$fstart = stripos($string, $from);
		$tmp = substr($string, $fstart + strlen($from));
		$flen = stripos($tmp, $to);
		return substr($tmp, 0, $flen);
	};
}
if (!(function_exists("getUqID")))
{
	function getUqID() {

		return mt_rand(0, 9999999);
	};
}
if (!(function_exists("build_http_query")))
{
	function build_http_query($query) {

		$query_array = array();
		foreach ($query as $key => $key_value)
		{
			$query_array[] = $key . "=" . urlencode($key_value);
			continue;
		}
		return implode("&", $query_array);
	};
}
if (!(function_exists("rndString")))
{
	function rndString($lngth) {

		$str = "";
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$size = strlen($chars);
		$i = 0;
		while ($lngth > $i)
		{
			$str .= $chars[rand(0, $size - 1)];
			$i++;
			continue;
		}
		return $str;
	};
}
if (!(function_exists("prcGSON")))
{
	function prcGSON($gson) {

		$json = substr($gson, 5);
		$json = str_replace(",{", ",{\"", $json);
		$json = str_replace(":[", "\":[", $json);
		$json = str_replace(",{\"\"", ",{\"", $json);
		$json = str_replace("\"\":[", "\":[", $json);
		$json = str_replace("[,", "[\"\",", $json);
		$json = str_replace(",,", ",\"\",", $json);
		$json = str_replace(",,", ",\"\",", $json);
		return $json;
	};
}
if (!(function_exists("wpspCheckSSLCurl")))
{
	function wpspCheckSSLCurl($url) {

		$ch = curl_init($url);
		$headers = array();
		$headers[] = "Accept: text/html, application/xhtml+xml, */*";
		$headers[] = "Cache-Control: no-cache";
		$headers[] = "Connection: Keep-Alive";
		$headers[] = "Accept-Language: en-us";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)");
		$content = curl_exec($ch);
		$err = curl_errno($ch);
		$errmsg = curl_error($ch);
		if ($err != 0)
		{
			return array("errNo" => $err, "errMsg" => $errmsg);
		}
		return false;
	};
}
if (!(function_exists("cookArrToStr")))
{
	function cookArrToStr($cArr) {

		$cs = "";
		if (!(is_array($cArr)))
		{
			return "";
		}
		foreach ($cArr as $cName => $cVal)
		{
			$cs .= $cName . "=" . $cVal . "; ";
			continue;
		}
		return $cs;
	};
}
if (!(function_exists("getCurlPageMC")))
{
	function getCurlPageMC($ch, $ref = "", $ctOnly = false, $fields = "", $dbg = false, $advSettings = "") {

		$ccURL = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		if ($dbg)
		{
			echo "<br/><b style=\"font-size:16px;color:green;\">#### START CURL:" . $ccURL . "</b><br/>";
		}
		static $curl_loops = 0;
		static $curl_max_loops = 20;
		global $wpsp_gCookiesArr;
		global $wpsp_cookiesarrayBD;
		$cookies = cookarrtostr($wpsp_gCookiesArr);
		if ($dbg)
		{
			echo "<br/><b style=\"color:#005800;\">## Request Cookies:</b><br/>";
			prr($cookies);
		}
		if ($curl_loops++ >= $curl_max_loops)
		{
			$curl_loops = 0;
			return false;
		}
		$headers = array();
		$headers[] = "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
		$headers[] = "Cache-Control: no-cache";
		$headers[] = "Connection: Keep-Alive";
		$headers[] = "Accept-Language: en-US,en;q=0.8";
		if ($fields != "")
		{
			if (stripos($ccURL, "http://www.blogger.com/blogger_rpc") !== false)
			{
				$headers[] = "Content-Type: application/javascript; charset=UTF-8";
			}
			else 
			{
				$headers[] = "Content-Type: application/x-www-form-urlencoded;charset=utf-8";
			}
		}
		if (stripos($ccURL, "http://www.blogger.com/blogger_rpc") !== false)
		{
			$headers[] = "X-GWT-Permutation: F8570AFBBDB4C20A963499D59CE98B57";
			$headers[] = "X-GWT-Module-Base: http://www.blogger.com/static/v1/gwt/";
		}
		if (isset($advSettings["liXMLHttpRequest"]))
		{
			$headers[] = "X-Requested-With: XMLHttpRequest";
		}
		if (isset($advSettings["Origin"]))
		{
			$headers[] = "Origin: " . $advSettings["Origin"];
		}
		if ((stripos($ccURL, "blogger.com") !== false) && ((isset($advSettings["cdomain"])) && ($advSettings["cdomain"] == "google.com")))
		{
			$pmp_setting_array["cdomain"] = "blogger.com";
		}
		if (isset($advSettings["noSSLSec"]))
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		}
		
		if (isset($advSettings["proxy"]) && $advSettings["proxy"]["host"] != "" && $advSettings["proxy"]["port"] !== "")
		{
			if ($dbg)
			{
				echo "<br/><b style=\"color:#005800;\">## Using Proxy:</b><br/>";
			}
			curl_setopt($ch, CURLOPT_TIMEOUT, 4);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			curl_setopt($ch, CURLOPT_PROXY, $advSettings["proxy"]["host"]);
			curl_setopt($ch, CURLOPT_PROXYPORT, $advSettings["proxy"]["port"]);
			if (isset($advSettings["proxy"]["up"]) && $advSettings["proxy"]["up"] != "")
			{
				curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_ANY);
				curl_setopt($ch, CURLOPT_PROXYUSERPWD, $advSettings["proxy"]["up"]);
			}
		}
		if (isset($advSettings["headers"]))
		{
			$headers = array_merge($headers, $advSettings["headers"]);
		}
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIE, $cookies);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		if (is_string($ref) && $ref != "")
		{
			curl_setopt($ch, CURLOPT_REFERER, $ref);
		}
		curl_setopt($ch, CURLOPT_USERAGENT, (isset($advSettings["UA"])) && ($advSettings["UA"] != "") ? $advSettings["UA"] : "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.44 Safari/537.36");
		if ($fields != "")
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		}
		 else 
		{
			curl_setopt($ch, CURLOPT_POST, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "");
			curl_setopt($ch, CURLOPT_HTTPGET, true);
		}
		
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		$content = curl_exec($ch);
		$errmsg = curl_error($ch);
		if (isset($errmsg) && stripos($errmsg, "SSL") !== false)
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$content = curl_exec($ch);
		}
		if ((strpos($content, "\n\n") != false) && strpos($content, "\n\n") < 100)
		{
			$content = substr_replace($content, "\n", strpos($content, "\n\n"), strlen("\n\n"));
		}
		if ((strpos($content, "\r\n\r\n") != false) && strpos($content, "\r\n\r\n") < 100)
		{
			$content = substr_replace($content, "\r\n", strpos($content, "\r\n\r\n"), strlen("\r\n\r\n"));
		}
		$ndel = strpos($content, "\n\n");
		$rndel = strpos($content, "\r\n\r\n");
		if ($ndel == false)
		{
			$ndel = 100000;
		}
		if ($rndel == false)
		{
			$rndel = 100000;
		}
		$rrDel = $ndel > $rndel ? "\r\n\r\n" : "\n\n";
		
		list($header, $content) = explode($rrDel, $content, 2);
		if ($ctOnly !== true)
		{
			$nsheader = curl_getinfo($ch);
			$err = curl_errno($ch);
			$errmsg = curl_error($ch);
			$nsheader["errno"] = $err;
			$nsheader["errmsg"] = $errmsg;
			$nsheader["headers"] = $header;
			$nsheader["content"] = $content;
		}
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$headers = curl_getinfo($ch);
		
		if ($dbg)
		{
			echo "<br/><b style=\"color:#005800;\">## Headers:</b><br/>";
			prr($headers);
			prr($header);
		}
		$results = array();
		preg_match_all("|Host: (.*)\\n|U", $headers["request_header"], $results);
		$ckDomain = str_replace(".", "_", $results[1][0]);
		$ckDomain = str_replace("\r", "", $ckDomain);
		$ckDomain = str_replace("\n", "", $ckDomain);
		if ($pmp_backgrd_check)
		{
			echo "<br/><b style=\"color:#005800;\">## Domain:</b><br/>";
			prr($ckDomain);
		}
		
		$results = array();
		$cookies = "";
		preg_match_all("|Set-Cookie: (.*);|U", $header, $results);
		$carTmp = $results[1];
		preg_match_all("/Set-Cookie: (.*)\\b/", $header, $xck);
		$xck = $xck[1];
		
		if ($dbg)
		{
			echo "Full Resp Cookies";
			prr($xck);
			echo "Plain Resp Cookies";
			prr($carTmp);
		}
		
		if (isset($advSettings["cdomain"]) && $advSettings["cdomain"] != "")
		{
			foreach ($carTmp as $iii => $cTmp)
			{
				if (!(stripos($xck[$iii], "Domain=") === false || stripos($xck[$iii], "Domain=." . $advSettings["cdomain"] . ";") !== false))
				{
					continue;
				}
				$ttt = explode("=", $cTmp, 2);
				$wpsp_gCookiesArr[$ttt[0]] = $ttt[1];
				continue;
			}
		}
		else 
		{
			foreach ($carTmp as $cTmp)
			{
				$ttt = explode("=", $cTmp, 2);
				$wpsp_gCookiesArr[$ttt[0]] = $ttt[1];
				continue;
			}
		}
		foreach ($carTmp as $cTmp)
		{
			$ttt = explode("=", $cTmp, 2);
			$wpsp_cookiesarrayBD[$ckDomain][$ttt[0]] = $ttt[1];
			continue;
		}
		if ($dbg)
		{
			echo "<br/><b style=\"color:#005800;\">## Common/Response Cookies:</b><br/>";
			prr($wpsp_gCookiesArr);
			echo "\r
\r
<br/>" . $ckDomain . "\r\n\r\n";
			prr($wpsp_cookiesarrayBD);
		}
		
		if ($dbg && $http_code == 200)
		{
			$contentH = htmlentities($content);
			prr($contentH);			
		}
		$rURL = "";
		
		if ($http_code == 200 && stripos($content, "http-equiv=\"refresh\" content=\"0; url=&#39;") !== false)
		{
			$http_code = 301;
			$rURL = cutfromto($content, "http-equiv=\"refresh\" content=\"0; url=&#39;", "&#39;\"");
			if (stripos($rURL, "blogger.com") === false)
			{
				$wpsp_gCookiesArr = array();
			}
		}
		else 
		{
			if (($http_code == 200) && (stripos($content, "location.replace") !== false))
			{
				$http_code = 301;
				$rURL = cutfromto($content, "location.replace(\"", "\"");
			}
		}
		if ($http_code == 301 || $http_code == 302 || $http_code == 303)
		{
			if ($rURL != "")
			{
				$rURL = str_replace("\\x3d", "=", $rURL);
				$rURL = str_replace("\\x26", "&", $rURL);
				$url = @parse_url($rURL);
			}
			 else 
			{
				$matches = array();
				preg_match("/Location:(.*?)\\n/", $header, $matches);
				$url = @parse_url(trim(array_pop($matches)));
			}
			$rURL = "";
			if (!$url)
			{
				$curl_loops = 0;
				return $pmp_ocheck === true ? $content : $nsheader;
			}
			$last_urlX = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
			$last_url = @parse_url($last_urlX);
			if (!(isset($url["scheme"])))
			{
				$url["scheme"] = $last_url["scheme"];
			}
			if (!(isset($url["host"])))
			{
				$url["host"] = $last_url["host"];
			}
			if (!$url["path"])
			{
				$url["path"] = $last_url["path"];
			}
			if (!(isset($url["query"])))
			{
				$url["query"] = "";
			}
			$new_url = $url["scheme"] . "://" . $url["host"] . $url["path"] . ($url["query"] ? "?" . $url["query"] : "");
			curl_setopt($ch, CURLOPT_URL, $new_url);
			if ($dbg)
			{
				echo "<br/><b style=\"color:#005800;\">Redirecting to:</b>" . $new_url . "<br/>";
			}
			return getcurlpagemc($ch, $last_urlX, $ctOnly, "", $dbg, $advSettings);
		}
		$curl_loops = 0;
		return $ctOnly === true ? $content : $nsheader;
	};
}

if (!(function_exists("getCurlPageX")))
{
	function getcurlpagex($url, $ref = "", $ctOnly = false, $fields = "", $dbg = false, $advSettings = "") {

		if ($dbg)
		{
			echo "<br/><b style=\"font-size:16px;color:green;\">#### GSTART URL:" . $url . "</b><br/>";
		}
		$ch = curl_init($url);
		$contents = getcurlpagemc($ch, $ref, $ctOnly, $fields, $dbg, $advSettings);
		curl_close($ch);
		return $contents;
	};
}

if (!(function_exists("doConnectToGooglePlus")))
{
	function doConnectToGooglePlus($connectID, $email, $pass) {

		return conncetwithgoogleplus($email, $pass);
	};
}
if (!(function_exists("doGetGoogleUrlInfo")))
{
	function doGetGoogleUrlInfo($connectID, $url) {

		return getlinkandtitle($url);
	};
}
if (!(function_exists("PostOnGooglePlusapi")))
{
	function PostOnGooglePlusapi($connectID, $msg, $lnk = "") {

		return PostOnGooglePlus($msg, $lnk);
	};
}
if (!(function_exists("conncetwithgoogleplus")))
{
	function conncetwithgoogleplus($email, $pass, $srv = "GP") {

		global $wpsp_gCookiesArr;
		global $wpsp_gCookiesArrBD;
		global $gPlusRecoveryEmail;
		global $gPlusRecoveryPhone;
		$wpsp_gCookiesArr = array();
		$advSettings = array();
		if ($gPlusRecoveryPhone == "" && isset($_COOKIE["gPlusRecoveryPhone"]) && $_COOKIE["gPlusRecoveryPhone"] != "")
		{
			$gPlusRecoveryPhone = $_COOKIE["gPlusRecoveryPhone"];
			if (!(headers_sent()))
			{
				setcookie("gPlusRecoveryPhone", "", time() - 3600);
				setcookie("gPlusRecoveryPhoneHint", "", time() - 3600);
			}
		}
		if ($gPlusRecoveryEmail == "" && isset($_COOKIE["gPlusRecoveryEmail"]) && $_COOKIE["gPlusRecoveryEmail"] != "")
		{
			$gPlusRecoveryEmail = $_COOKIE["gPlusRecoveryEmail"];
			if (!(headers_sent()))
			{
				setcookie("gPlusRecoveryEmail", "", time() - 3600);
				setcookie("gPlusRecoveryEmailHint", "", time() - 3600);
			}
		}
		$err = wpspCheckSSLCurl("https://accounts.google.com/ServiceLogin");
		
		if ($err !== false && $err["errNo"] == "60")
		{
			$advSettings["noSSLSec"] = true;
		}
		if ($srv == "GP")
		{
			$lpURL = "https://accounts.google.com/ServiceLogin?service=oz&continue=https://plus.google.com/?gpsrc%3Dogpy0%26tab%3DwX%26gpcaz%3Dc7578f19&hl=en-US";
		}
		if ($srv == "YT")
		{
			$lpURL = "https://accounts.google.com/ServiceLogin?service=oz&checkedDomains=youtube&checkConnection=youtube%3A271%3A1%2Cyoutube%3A69%3A1&continue=https://www.youtube.com/&hl=en-US";
		}
		if ($srv == "BG")
		{
			$lpURL = "https://accounts.google.com/ServiceLogin?service=blogger&passive=1209600&continue=http://www.blogger.com/home&followup=http://www.blogger.com/home&ltmpl=start#s01";
		}
		
		$contents = getcurlpagex($lpURL, "", true, "", false, $advSettings);
		
		$md = array();
		$mids = "";
		$flds = array();
		
		while (stripos($contents, "<input") !== false)
		{
			$inpField = trim(cutfromto($contents, "<input", ">"));
			$name = trim(cutfromto($inpField, "name=\"", "\""));
			
			if ((stripos($inpField, "\"hidden\"") !== false) && ($name != "") && !(in_array($name, $md)))
			{
				$md[] = $name;
				$val = trim(cutfromto($inpField, "value=\"", "\""));
				$flds[$name] = $val;
				$mids .= "&" . $name . "=" . $val;
			}
			$contents = substr($contents, stripos($contents, "<input") + 8);
			continue;
		}
		
		$flds["Email"] = $email;
		$flds["Passwd"] = $pass;
		$flds["signIn"] = "Sign%20in";
		$fldsTxt = build_http_query($flds);
		if ($srv == "GP" || $srv == "BG")
		{
			$advSettings["cdomain"] = "google.com";
		}
		$contents = getcurlpagex("https://accounts.google.com/ServiceLoginAuth", "", false, $fldsTxt, false, $advSettings);
		if ($srv == "YT")
		{
			unset($advSettings["cdomain"]);
			$wpsp_gCookiesArr = $wpsp_gCookiesArrBD["accounts_youtube_com"];
		}
		if ((stripos($contents["url"], "https://accounts.google.com/ServiceLoginAuth") !== false) && (stripos($contents["content"], "<span color=\"red\">") !== false))
		{
			return cutfromto($contents["content"], "<span color=\"red\">", "</span>");
		}
		if (stripos($contents["url"], "NewPrivacyPolicy") !== false)
		{
			return "Please login to your account and accept new \"New Privacy Policy\"";
		}
		if (stripos($contents["content"], "captcha-box") !== false || stripos($contents["content"], "CaptchaChallengeOptionContent") !== false)
		{
			return "Captcha is \"On\" for your account. Please login to your account from the bworser and try clearing the CAPTCHA by visiting this link: <a href=\"https://www.google.com/accounts/DisplayUnlockCaptcha\" target=\"_blank\">https://www.google.com/accounts/DisplayUnlockCaptcha</a>. If you're a Google Apps user, visit https://www.google.com/a/yourdomain.com/UnlockCaptcha in order to clear the CAPTCHA. Be sure to replace 'yourdomain.com' with your actual domain name.";
		}
		
		if (stripos($contents["url"], "ServiceLoginAuth") !== false)
		{
			return "Incorrect Username/Password " . $contents["errmsg"];
		}
		if (stripos($contents["url"], "google.com/SmsAuth") !== false || stripos($contents["url"], "google.com/SecondFactor") !== false)
		{
			return "2-step verification in on.";	
		}
		$contents["content"] = str_ireplace("'CREATE_CHANNEL_DIALOG_TITLE_IDV_CHALLENGE': \"Verify your identity\"", "", $contents["content"]);
		if (stripos($contents["content"], "is that really you") !== false || stripos($contents["content"], "Verify your identity") !== false || stripos($contents["url"], "LoginVerification") !== false)
		{
			$text = $contents["content"];
			$flds = array();
			while (stripos($text, "\"hidden\"") !== false)
			{
				$text = substr($text, stripos($text, "\"hidden\"") + 8);
				$name = trim(cutfromto($text, "name=\"", "\""));
				if (!!(in_array($name, $md)))
				{
					continue;
				}
				$md[] = $name;
				$val = trim(cutfromto($text, "value=\"", "\""));
				$flds[$name] = $val;
				$mids .= "&" . $name . "=" . $val;
				continue;
			}
		}
		return false;
	};
}
if (!(function_exists("getlinkandtitle")))
{
	function getlinkandtitle($url) {

		$rnds = rndstring(13);
		$url = urlencode($url);
		$contents = getcurlpagex("https://plus.google.com/", "", false);
		$at = cutfromto($contents["content"], "csi.gstatic.com/csi\",\"", "\",");
		$spar = "susp=false&at=" . $at . "&";
		$gurl = "https://plus.google.com/u/1/_/sharebox/linkpreview/?c=" . $url . "&t=1&slpf=0&ml=1&_reqid=1064097&rt=j";
		$contents = getcurlpagex($gurl, "", false, $spar);
		$json = prcgson($contents["content"]);
		$arr = json_decode($json, true);
		if (!(is_array($arr)))
		{
			return;
		}
		list(, list(, , , , list(list(, $out["link"])))) = $arr[0];
		list(, list(, , , , list(list(, , $out["fav"])))) = $arr[0];
		list(, list(, , , , list(list(, , , $out["title"])))) = $arr[0];
		list(, list(, , , , list(list(, , , , $out["domain"])))) = $arr[0];
		list(, list(, , , , list(list(, , , , , , , $out["txt"])))) = $arr[0];
		list(, list(, , , , list(list(, , , , , , list(list(, , , , , , , , $out["img"])))))) = $arr[0];
		list(, list(, , , , list(list(, , , , , , list(list(, $out["imgType"])))))) = $arr[0];
		$out["title"] = str_replace("&#39;", "'", $out["title"]);
		$out["txt"] = str_replace("&#39;", "'", $out["txt"]);
		$out["txt"] = html_entity_decode($out["txt"]);
		$out["title"] = html_entity_decode($out["title"]);
		return $out;
	};
}
if (!(function_exists("PostOnGooglePlus")))
{
	function PostOnGooglePlus($msg, $lnk = "") {

		$rnds = rndstring(13);
		$new= '';
		$ownerID = "";
		$bigCode = "";
		
		if (function_exists("wpsp_decodeEntitiesFull"))
		{
			$msg = wpsp_decodeentitiesfull($msg);
		}
		if (function_exists("wpsp_html_to_utf8"))
		{
			$msg = wpsp_html_to_utf8($msg);
		}
		$msg = str_replace("<br>", "_NXSZZwpsp_5Cn", $msg);
		$msg = str_replace("<br/>", "_NXSZZwpsp_5Cn", $msg);
		$msg = str_replace("<br />", "_NXSZZwpsp_5Cn", $msg);
		$msg = str_replace("\r\n", "\n", $msg);
		$msg = str_replace("
\r", "\n", $msg);
		$msg = str_replace("\r", "\n", $msg);
		$msg = str_replace("\n", "_NXSZZwpsp_5Cn", $msg);
		$msg = str_replace("\"", "\\\"", $msg);
		$msg = urlencode(strip_tags($msg));
		$msg = str_replace("_NXSZZwpsp_5Cn", "%5Cn", $msg);
		$msg = str_replace("+", "%20", $msg);
		$msg = str_replace("%0A%0A", "%20", $msg);
		$msg = str_replace("%0A", "", $msg);
		$msg = str_replace("%0D", "%5C", $msg);
		if ($lnk == "")
		{
			$lnk = array("img" => "", "link" => "", "fav" => "", "domain" => "", "title" => "", "txt" => "");
		}
		
		if (isset($lnk["img"]) && trim($lnk["img"]) != "")
		{
			$img = getcurlpagex($lnk["img"], "", false);
			if ($img["http_code"] == "200" && $img["content_type"] != "text/html")
			{
				$lnk["imgType"] = urlencode($img["content_type"]);
				
			}
			 else 
			{
				$lnk["img"] = "";
			}
		}
		if (isset($lnk["img"]))
		{
			$lnk["img"] = urlencode($lnk["img"]);
		}
		if (isset($lnk["link"]))
		{
			$lnk["link"] = urlencode($lnk["link"]);
		}
		if (isset($lnk["fav"]))
		{
			$lnk["fav"] = urlencode($lnk["fav"]);
		}
		if (isset($lnk["domain"]))
		{
			$lnk["domain"] = urlencode($lnk["domain"]);
		}
		if (isset($lnk["title"]))
		{
			$lnk["title"] = str_replace(array("\n", "\r"), " ", $lnk["title"]);
			$lnk["title"] = rawurlencode(addslashes($lnk["title"]));
		}
		if (isset($lnk["txt"]))
		{
			$lnk["txt"] = str_replace(array("\n", "\r"), " ", $lnk["txt"]);
			$lnk["txt"] = rawurlencode(addslashes($lnk["txt"]));
		}
		$refPage = "https://plus.google.com/b/" . $new . "/";
		$gpp = "https://plus.google.com/_/sharebox/post/?spam=20&_reqid=1203718&rt=j";
		$contents = getcurlpagex("https://plus.google.com/", "", false);
		$new = cutfromto($contents["content"], "key: '2'", "]");
		$new = cutfromto($new, "https://plus.google.com/", "\"");
			
		if ($contents["http_code"] == "400")
		{
			return "Invalid Sharebox Page. Something is wrong, please contact support";
		}
		$at = cutfromto($contents["content"], "csi.gstatic.com/csi\",\"", "\",");
		if (!(isset($lnk["txt"])))
		{
			$lnk["txt"] = "";
		}
		$txttxt = $lnk["txt"];
		$txtStxt = str_replace("%5C", "%5C%5C%5C%5C%5C%5C%5C", $lnk["txt"]);
			$proOrCommTxt = "%5D%2C%5B%5B%5Bnull%2Cnull%2C1%5D%5D%2Cnull";
		
		if (isset($lnk["link"]) && trim($lnk["link"]) != "")
		{
			$spar = "f.req=%5B%22" . $msg . "%22%2C%22oz%3A" . $new . "." . $rnds . ".1%22%2Cnull%2Cnull%2Cnull%2Cnull%2C%22%5B%5C%22%5Bnull%2Cnull%2Cnull%2C%5C%5C%5C%22" . str_replace("%5C", "%5C%5C%5C%5C%5C%5C%5C", $lnk["title"]) . "%5C%5C%5C%22%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22" . $lnk["link"] . $ownerID . "%5C%5C%5C%22%2C%5C%5C%5C%22owner%5C%5C%5C%22%5D%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5C%5C%5C%22" . str_replace("%5C", "%5C%5C%5C%5C%5C%5C%5C", $lnk["txt"]) . "%5C%5C%5C%22%2Cnull%2Cnull%2C%5Bnull%2C%5C%5C%5C%22" . $lnk["link"] . "%5C%5C%5C%22%2Cnull%2C%5C%5C%5C%22text%2Fhtml%5C%5C%5C%22%2C%5C%5C%5C%22document%5C%5C%5C%22%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22%2F%2Fs2.googleusercontent.com%2Fs2%2Ffavicons%3Fdomain%3Dwww." . $lnk["domain"] . "%5C%5C%5C%22%2Cnull%2Cnull%5D%2C%5Bnull%2C%5C%5C%5C%22%2F%2Fs2.googleusercontent.com%2Fs2%2Ffavicons%3Fdomain%3Dwww." . $lnk["domain"] . "%5C%5C%5C%22%2Cnull%2Cnull%5D%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22%5C%5C%5C%22%2C%5C%5C%5C%22http%3A%2F%2Fgoogle.com%2Fprofiles%2Fmedia%2Fprovider%5C%5C%5C%22%2C%5C%5C%5C%22%5C%5C%5C%22%5D%2C%5Bnull%2C%5C%5C%5C%22" . $lnk["link"] . "%5C%5C%5C%22%2C%5C%5C%5C%22http%3A%2F%2Fgoogle.com%2Fprofiles%2Fmedia%2Fcanonical_id%5C%5C%5C%22%2C%5C%5C%5C%22%5C%5C%5C%22%5D%5D%5D%5C%22%2C%5C%22%5Bnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5Bnull%2C%5C%5C%5C%22" . $lnk["img"] . "%5C%5C%5C%22%5D%2Cnull%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5Bnull%2C%5C%5C%5C%22" . $lnk["link"] . "%5C%5C%5C%22%2Cnull%2C%5C%5C%5C%22" . $lnk["imgType"] . "%5C%5C%5C%22%2C%5C%5C%5C%22photo%5C%5C%5C%22%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C250%2C178%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22" . $lnk["img"] . "%5C%5C%5C%22%2Cnull%2Cnull%5D%2C%5Bnull%2C%5C%5C%5C%22" . $lnk["img"] . "%5C%5C%5C%22%2Cnull%2Cnull%5D%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22images%5C%5C%5C%22%2C%5C%5C%5C%22http%3A%2F%2Fgoogle.com%2Fprofiles%2Fmedia%2Fprovider%5C%5C%5C%22%2C%5C%5C%5C%22%5C%5C%5C%22%5D%5D%5D%5C%22%5D%22%2Cnull%2Cnull%2Ctrue%2C%5B%5D%2Cfalse%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cfalse%2Cfalse%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5B35%2C1%2C0%5D%2C%22" . $lnk["link"] . "%22%2Cnull%2Cnull%2Cnull%2C%7B%2229646191%22%3A%5B%22" . $lnk["link"] . "%22%2C%22" . $lnk["img"] . "%22%2C%22" . $lnk["title"] . "%22%2C%22" . $txttxt . "%22%2Cnull%2C%5B%22%2F%2Fimages1-focus-opensocial.googleusercontent.com%2Fgadgets%2Fproxy%3Furl%3D" . $lnk["img"] . "%26container%3Dfocus%26gadget%3Da%26rewriteMime%3Dimage%2F*%26refresh%3D31536000%26resize_h%3D150%26resize_w%3D150%26no_expand%3D1%22%2C150%2C150%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B3%2C%22https%3A%2F%2Fimages2-focus-opensocial.googleusercontent.com%2Fgadgets%2Fproxy%3Furl%3D" . $lnk["img"] . "%26container%3Dfocus%26gadget%3Dhttps%3A%2F%2Fplus.google.com%26rewriteMime%3Dimage%2F*%26resize_h%3D800%26resize_w%3D800%26no_expand%3D1%22%5D%5D%2C%22%2F%2Fs2.googleusercontent.com%2Fs2%2Ffavicons%3Fdomain%3Dwww." . $lnk["domain"] . "%22%2C%5B%5B%5B5%2C0%5D%2Cnull%2Cnull%2Cnull%2Cnull%2C%7B%2227219582%22%3A%5Bnull%2Cnull%2Cnull%2C%22" . $lnk["link"] . $ownerID . "%22%5D%7D%5D%5D%2Cnull%2C%5B%5D%2C%22" . $lnk["domain"] . "%22%2Cnull%2C%5B%5D%2C%5B%5D%2C%5B%5D%2C%5B%5D%5D%7D%5D%2Cnull%2C%5B" . $proOrCommTxt . "%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%22!" . $bigCode . "%22%5D&at=" . $at . "&";
		}
		 else 
		{
				if (isset($lnk["img"]) && trim($lnk["img"]) != "")
				{
					
					$remImgURL = urldecode($lnk["img"]);
					$urlParced = pathinfo($remImgURL);
					$remImgURLFilename = $urlParced["basename"];
					$imgData = getcurlpagex($remImgURL, "", false);
					$imgdSize = $imgData["download_content_length"];
					if ($imgdSize == "-1")
					{
						$imgdSize = $imgData["size_download"];
					}
					$imgData = $imgData["content"];
					if ($isPostToPage)
					{
						$pgAddFlds = "{\"inlined\":{\"name\":\"effective_id\",\"content\":\"" . $new . "\",\"contentType\":\"text/plain\"}},{\"inlined\":{\"name\":\"owner_name\",\"content\":\"" . $new . "\",\"contentType\":\"text/plain\"}},";
					}
					 else 
					{
						$pgAddFlds = "";


					}
					$iflds = "{\"protocolVersion\":\"0.8\",\"createSessionRequest\":{\"fields\":[{\"external\":{\"name\":\"file\",\"filename\":\"" . $remImgURLFilename . "\",\"put\":{},\"size\":" . $imgdSize . "}},{\"inlined\":{\"name\":\"batchid\",\"content\":\"1350593121640\",\"contentType\":\"text/plain\"}},{\"inlined\":{\"name\":\"client\",\"content\":\"sharebox\",\"contentType\":\"text/plain\"}},{\"inlined\":{\"name\":\"disable_asbe_notification\",\"content\":\"true\",\"contentType\":\"text/plain\"}},{\"inlined\":{\"name\":\"streamid\",\"content\":\"updates\",\"contentType\":\"text/plain\"}},{\"inlined\":{\"name\":\"use_upload_size_pref\",\"content\":\"true\",\"contentType\":\"text/plain\"}}," . $pgAddFlds . "{\"inlined\":{\"name\":\"album_abs_position\",\"content\":\"0\",\"contentType\":\"text/plain\"}}]}}";
					
					$imgReqCnt = getcurlpagex("https://plus.google.com/_/upload/photos/resumable?authuser=0", "", false, $iflds);
					$gUplURL = str_replace("\\u0026", "&", cutfromto($imgReqCnt["content"], "putInfo\":{\"url\":\"", "\""));
					$gUplID = cutfromto($imgReqCnt["content"], "upload_id\":\"", "\"");
					$imgUplCnt = getcurlpagex($gUplURL, "", true, $imgData);
					$parts = explode("\n", $imgUplCnt);
					$json = end($parts);
					$imgUplCnt = json_decode($json, true);
					$infoArray = $imgUplCnt["sessionStatus"]["additionalInfo"]["uploader_service.GoogleRupioAdditionalInfo"]["completionInfo"]["customerSpecificInfo"];
					$albumID = $infoArray["albumid"];
					$photoid = $infoArray["photoid"];
					$imgUrl = urlencode($infoArray["url"]);
					$imgTitie = $infoArray["title"];
					$width = $infoArray["width"];
					$height = $infoArray["height"];
					$userID = $infoArray["username"];
					$intID = $infoArray["albumPageUrl"];
					$intID = str_replace("https://picasaweb.google.com/", "", $intID);
					$intID = str_replace($userID, "", $intID);
					$intID = str_replace("/", "", $intID);
					$spar = "f.req=%5B%22" . $msg . "%22%2C%22oz%3A" . $new . "." . $rnds . ".0%22%2Cnull%2C%22" . $albumID . "%22%2Cnull%2Cnull%2C%22%5B%5C%22%5Bnull%2Cnull%2Cnull%2C%5C%5C%5C%22%5C%5C%5C%22%2Cnull%2C%5Bnull%2C%5C%5C%5C%22" . $imgUrl . "%5C%5C%5C%22%2C" . $height . "%2C" . $width . "%5D%2Cnull%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5C%5C%5C%22" . $imgTitie . "%5C%5C%5C%22%2Cnull%2Cnull%2C%5Bnull%2C%5C%5C%5C%22https%3A%2F%2Fpicasaweb.google.com%2F" . $userID . "%2F" . $intID . "%23" . $photoid . "%5C%5C%5C%22%2Cnull%2C%5C%5C%5C%22image%2Fjpeg%5C%5C%5C%22%2C%5C%5C%5C%22image%5C%5C%5C%22%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22" . $imgUrl . "%5C%5C%5C%22%2C120%2C120%5D%2C%5Bnull%2C%5C%5C%5C%22" . $imgUrl . "%5C%5C%5C%22%2C120%2C120%5D%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22picasa%5C%5C%5C%22%2C%5C%5C%5C%22http%3A%2F%2Fgoogle.com%2Fprofiles%2Fmedia%2Fprovider%5C%5C%5C%22%2C%5C%5C%5C%22%5C%5C%5C%22%5D%2C%5Bnull%2C%5C%5C%5C%22albumid%3D" . $albumID . "%26photoid%3D" . $photoid . "%5C%5C%5C%22%2C%5C%5C%5C%22http%3A%2F%2Fgoogle.com%2Fprofiles%2Fmedia%2Fonepick_media_id%5C%5C%5C%22%2C%5C%5C%5C%22%5C%5C%5C%22%5D%5D%5D%5C%22%5D%22%2Cnull%2Cnull%2Cfalse%2C%5B%5D%2Cnull%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cfalse%2Cnull%2Cnull%2C%22" . $userID . "%22%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Ctrue%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5B249%2C18%2C1%2C0%5D%2Cnull%2Cnull%2Cnull%2Cnull%2C%7B%2227639957%22%3A%5B%5B%22https%3A%2F%2Fpicasaweb.google.com%2F" . $userID . "%2F" . $intID . "%23" . $photoid . "%22%2C%22" . $imgTitie . "%22%2C%22%22%2C%22" . $imgUrl . "%22%2Cnull%2C%5B%22" . str_ireplace("https%3A", "", $imgUrl) . "%22%2C497%2C373%2Cnull%2Cnull%2Cnull%2Cnull%2C60%2C%5B1%2C%22" . $imgUrl . "%22%5D%5D%2Cnull%2C%2260%22%2C%2260%22%2C60%2C60%2Cnull%2C%22picasaweb.google.com%22%5D%2C%22" . $userID . "%22%2Cnull%2C%22" . $photoid . "%22%2Cnull%2Cnull%2C%22" . $imgUrl . "%22%2Cnull%2Cnull%2C%22https%3A%2F%2Fpicasaweb.google.com%2F" . $userID . "%2F" . $intID . "%23" . $photoid . "%22%2Cnull%2C%22albumid%3D" . $albumID . "%26photoid%3D" . $photoid . "%22%2C1%2C%5B%5D%5D%7D%5D%2Cnull%2C%5B" . $proOrCommTxt . "%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%22!" . $bigCode . "%22%5D&at=" . $at . "&";
				}
				 else 
				{
					$spar = "f.req=%5B%22" . $msg . "%22%2C%22oz%3A" . $new . "." . $rnds . ".0%22%2Cnull%2Cnull%2Cnull%2Cnull%2C%22%5B%5D%22%2Cnull%2Cnull%2Cfalse%2C%5B%5D%2Cnull%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B" . $proOrCommTxt . "%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%22!" . $bigCode . "%22%5D&at=" . $at . "&";
				}
			}
		
		$spar = str_ireplace("+", "%20", $spar);
		$spar = str_ireplace(":", "%3A", $spar);
		$contents = getcurlpagex($gpp, $refPage, false, $spar);
		
		if ($contents["http_code"] == "403")
		{
			return "Error: You are not authorized to publish to this page. Are you sure this is even a page?";
		}
		if ($contents["http_code"] == "404")
		{
			return "Error: Page you are posting is not found.<br/><br/> If you have entered your page ID as 117008619877691455570/117008619877691455570, please remove the second copy. It should be one number only - 117008619877691455570";
		}
		if ($contents["http_code"] == "400")
		{
			return "Error (400): Something is wrong, please contact support";
		}
		if ($contents["http_code"] == "500")
		{	
			return "Error (500): Something is wrong, please contact support";
		}
		if ($contents["http_code"] == "200")
		{
			$ret = $contents["content"];
			$remTxt = cutfromto($ret, "\"{\\\"", "}\"");
			$ret = str_replace($remTxt, "", $ret);
			$ret = prcgson($ret);
			$ret = json_decode($ret, true);
			list(, list(, list(list(list(, , , , , , , , , , , , , , , , , , , , , $ret))))) = $ret[0];
			return array("code" => "OK", "post_id" => $ret);
		}
		return print_r($contents, true);
	};
}

