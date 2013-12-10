<?php
function curloptposandget($ch)
{
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "");
	curl_setopt($ch, CURLOPT_HTTPGET, true);	
}
//This function check domain
function checkdomaingp($servicegpurl,$wpspadvsettings)
{
		$servicegpurl = "https://accounts.google.com/ServiceLogin?service=oz&continue=https://plus.google.com/?gpsrc%3Dogpy0%26tab%3DwX%26gpcaz%3Dc7578f19&hl=en-US";	
	
	$hdcheck = getcurlpagex($servicegpurl, "", true, "", $wpspadvsettings);
	return $hdcheck;
}
	
//this function used for random generate string	
function GeraHash($qtd){
//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
$Caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVXWYZ';
$QuantidadeCaracteres = strlen($Caracteres);
$QuantidadeCaracteres--;
$Hash=NULL;
    for($x=1;$x<=$qtd;$x++){
        $Posicao = rand(0,$QuantidadeCaracteres);
        $Hash .= substr($Caracteres,$Posicao,1);
    }
return $Hash;
} 
//This function check header	
function headersofssl()
{
	$headers = array();
	$headers[] = "Accept: text/html, application/xhtml+xml, */*";
	$headers[] = "Cache-Control: no-cache";
	$headers[] = "Connection: Keep-Alive";
	$headers[] = "Accept-Language: en-us";	
	return $headers;
}
//This function check curl ssl verifyhost
function curlsllver($ch)
{
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
}
//This funtion check cookies in header 
function curloptcokhead($ch,$cookies,$headers)
{
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIE, $cookies);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
}
function curlhostcheck($prhost,$prport,$prup){
	    
		curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
		curl_setopt($ch, CURLOPT_PROXY, $prhost);
		curl_setopt($ch, CURLOPT_PROXYPORT, $prport);
		if (isset($prup) && $prup != "")
		{
			curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $prup);
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, 4);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
}
		
//This funtion check ssl url with return transfer header
function wpspCheckSSLCurl($url) 
{
	$ch = curl_init($url);
	$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; compatible; MSIE 9.0; WOW64; Trident/5.0; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
	$headers = headersofssl();
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	$content = curl_exec($ch);
	if (curl_errno($ch))
	{
		$errNo = curl_errno($ch);
		$errMsg = curl_error($ch);
		return array("errNo" => $errNo, "errMsg" => $errMsg);
	}
	return false;
}
//this funtion check for cookies to string
function cookArrToStr($cookiesarray) 
{
	foreach ($cookiesarray as $key => $val)
	{
		$ctos .= $key . "=" . $val . "; ";
	}
	return $ctos;
}
function linkwithmsgnew($msg,$new,$wpsppostlinktitle,$wpsppostlinktext,$wpsppostlinkdomain,$wpsppostlinkimg,$wpsppostlinklink,$wpsppostlinkimgType,$wpspownerid,$proOrCommTxt,$wpspbigcd,$gpatvalue)
{
	$rnds = GeraHash(13);
	return $wpspsprvl = "f.req=%5B%22" . $msg . "%22%2C%22oz%3A" . $new . "." . $rnds . ".1%22%2Cnull%2Cnull%2Cnull%2Cnull%2C%22%5B%5C%22%5Bnull%2Cnull%2Cnull%2C%5C%5C%5C%22" . str_replace("%5C", "%5C%5C%5C%5C%5C%5C%5C", $wpsppostlinktitle) . "%5C%5C%5C%22%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22" . $wpsppostlinklink . $wpspownerid . "%5C%5C%5C%22%2C%5C%5C%5C%22owner%5C%5C%5C%22%5D%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5C%5C%5C%22" . str_replace("%5C", "%5C%5C%5C%5C%5C%5C%5C", $wpsppostlinktext) . "%5C%5C%5C%22%2Cnull%2Cnull%2C%5Bnull%2C%5C%5C%5C%22" . $wpsppostlinklink . "%5C%5C%5C%22%2Cnull%2C%5C%5C%5C%22text%2Fhtml%5C%5C%5C%22%2C%5C%5C%5C%22document%5C%5C%5C%22%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22%2F%2Fs2.googleusercontent.com%2Fs2%2Ffavicons%3Fdomain%3Dwww." . $wpsppostlinkdomain . "%5C%5C%5C%22%2Cnull%2Cnull%5D%2C%5Bnull%2C%5C%5C%5C%22%2F%2Fs2.googleusercontent.com%2Fs2%2Ffavicons%3Fdomain%3Dwww." . $wpsppostlinkdomain . "%5C%5C%5C%22%2Cnull%2Cnull%5D%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22%5C%5C%5C%22%2C%5C%5C%5C%22http%3A%2F%2Fgoogle.com%2Fprofiles%2Fmedia%2Fprovider%5C%5C%5C%22%2C%5C%5C%5C%22%5C%5C%5C%22%5D%2C%5Bnull%2C%5C%5C%5C%22" . $wpsppostlinklink . "%5C%5C%5C%22%2C%5C%5C%5C%22http%3A%2F%2Fgoogle.com%2Fprofiles%2Fmedia%2Fcanonical_id%5C%5C%5C%22%2C%5C%5C%5C%22%5C%5C%5C%22%5D%5D%5D%5C%22%2C%5C%22%5Bnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5Bnull%2C%5C%5C%5C%22" . $wpsppostlinkimg . "%5C%5C%5C%22%5D%2Cnull%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5Bnull%2C%5C%5C%5C%22" . $wpsppostlinklink . "%5C%5C%5C%22%2Cnull%2C%5C%5C%5C%22" . $wpsppostlinkimgType . "%5C%5C%5C%22%2C%5C%5C%5C%22photo%5C%5C%5C%22%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C250%2C178%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22" . $wpsppostlinkimg . "%5C%5C%5C%22%2Cnull%2Cnull%5D%2C%5Bnull%2C%5C%5C%5C%22" . $wpsppostlinkimg . "%5C%5C%5C%22%2Cnull%2Cnull%5D%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22images%5C%5C%5C%22%2C%5C%5C%5C%22http%3A%2F%2Fgoogle.com%2Fprofiles%2Fmedia%2Fprovider%5C%5C%5C%22%2C%5C%5C%5C%22%5C%5C%5C%22%5D%5D%5D%5C%22%5D%22%2Cnull%2Cnull%2Ctrue%2C%5B%5D%2Cfalse%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cfalse%2Cfalse%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5B35%2C1%2C0%5D%2C%22" . $wpsppostlinklink . "%22%2Cnull%2Cnull%2Cnull%2C%7B%2229646191%22%3A%5B%22" . $wpsppostlinklink . "%22%2C%22" . $wpsppostlinkimg . "%22%2C%22" . $wpsppostlinktitle . "%22%2C%22" . $txttxt . "%22%2Cnull%2C%5B%22%2F%2Fimages1-focus-opensocial.googleusercontent.com%2Fgadgets%2Fproxy%3Furl%3D" . $wpsppostlinkimg . "%26container%3Dfocus%26gadget%3Da%26rewriteMime%3Dimage%2F*%26refresh%3D31536000%26resize_h%3D150%26resize_w%3D150%26no_expand%3D1%22%2C150%2C150%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B3%2C%22https%3A%2F%2Fimages2-focus-opensocial.googleusercontent.com%2Fgadgets%2Fproxy%3Furl%3D" . $wpsppostlinkimg . "%26container%3Dfocus%26gadget%3Dhttps%3A%2F%2Fplus.google.com%26rewriteMime%3Dimage%2F*%26resize_h%3D800%26resize_w%3D800%26no_expand%3D1%22%5D%5D%2C%22%2F%2Fs2.googleusercontent.com%2Fs2%2Ffavicons%3Fdomain%3Dwww." . $wpsppostlinkdomain . "%22%2C%5B%5B%5B5%2C0%5D%2Cnull%2Cnull%2Cnull%2Cnull%2C%7B%2227219582%22%3A%5Bnull%2Cnull%2Cnull%2C%22" . $wpsppostlinklink . $wpspownerid . "%22%5D%7D%5D%5D%2Cnull%2C%5B%5D%2C%22" . $wpsppostlinkdomain . "%22%2Cnull%2C%5B%5D%2C%5B%5D%2C%5B%5D%2C%5B%5D%5D%7D%5D%2Cnull%2C%5B" . $proOrCommTxt . "%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%22!" . $wpspbigcd . "%22%5D&at=" . $gpatvalue . "&";
}
function curlpagemanage($ch, $reference = "", $wpspcontentonly = false, $wpspfieldsgp = "", $wpspadvsettings = "") 
{
	global $wpsp_gpsession;
	global $wpsp_arraysession;
	global $wpsp_gpckarray;
	global $wpsp_cookiesarrayBD;
	
	$headers = array();
	$headers[] = "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
	$headers[] = "Cache-Control: no-cache";
	$headers[] = "Connection: Keep-Alive";
	$headers[] = "Accept-Language: en-US,en;q=0.8";
	$headers[] = "X-Requested-With: XMLHttpRequest";
	$headers[] = "Origin: " . $wpspadvsettings["Origin"];
	
	$cookies = cookarrtostr($wpsp_gpckarray);
	
	//Check Ssl
	if ($wpspfieldsgp != "")
	{
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $wpspfieldsgp);
	}
	else 
	{
		curloptposandget($ch);
	}
	curloptcokhead($ch,$cookies,$headers);
	if($reference != "")
	{
		curl_setopt($ch, CURLOPT_REFERER, $reference);
	}
	//curl_setopt($ch,CURLOPT_USERAGENT,$agents[array_rand($agents)]);
	curl_setopt($ch, CURLOPT_USERAGENT, (isset($wpspadvsettings["UA"])) && ($wpspadvsettings["UA"] != "") ? $wpspadvsettings["UA"] : "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.44 Safari/537.36");
	
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
	$content = curl_exec($ch);
	$valwpsss = stripos($content, "http-equiv=\"refresh\" content=\"0; url=&#39;");
	$wpspnewrnew = "\r\n\r\n" ;
	list($header, $content) = explode($wpspnewrnew, $content, 2);
	$nsheader = curl_getinfo($ch);
	$err = curl_errno($ch);
	$errmsg = curl_error($ch);
	$nsheader["errno"] = $err;
	$nsheader["errmsg"] = $errmsg;
	$nsheader["headers"] = $header;
	$nsheader["content"] = $content;
	
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$headers = curl_getinfo($ch);
	
	//Cookies set
	$results = array();
	preg_match_all("|Host: (.*)\\n|U", $headers["request_header"], $results);
	$ckDomain = str_replace(".", "_", $results[1][0]);
	$ckDomain = str_replace("\r", "", $ckDomain);
	$ckDomain = str_replace("\n", "", $ckDomain);
	
	$results = array();
	$cookies = "";
	preg_match_all("|Set-Cookie: (.*);|U", $header, $results);
	$wpspcktmpvl = $results[1];
	preg_match_all("/Set-Cookie: (.*)\\b/", $header, $xck);
	$xck = $xck[1];
	
	foreach ($wpspcktmpvl as $wpspdomainval)
	{
		$wpspcktotal = explode("=", $wpspdomainval, 2);
		$wpsp_cookiesarrayBD[$ckDomain][$wpspcktotal[0]] = $wpspcktotal[1];
		continue;
	}
	
	if (isset($wpspadvsettings["cdomain"]) && $wpspadvsettings["cdomain"] != "")
	{
		foreach ($wpspcktmpvl as $wpspdomainkey => $wpspdomainval)
		{
			$cookick = stripos($xck[$wpspdomainkey], "Domain=." . $wpspadvsettings["cdomain"] . ";");
			$xckvl = stripos($xck[$wpspdomainkey], "Domain=");
			if (!($xckvl === false || $cookick !== false))
			{
				continue;
			}
			$wpspcktotal = explode("=", $wpspdomainval, 2);
			$wpsp_gpckarray[$wpspcktotal[0]] = $wpspcktotal[1];
			continue;
		}
	}
	else 
	{
		
		foreach ($wpspcktmpvl as $wpspdomainval)
		{
			$wpspcktotal = explode("=", $wpspdomainval, 2);
			$wpsp_gpckarray[$wpspcktotal[0]] = $wpspcktotal[1];
			continue;
		}
	}
	
	$rURL = "";
	$wpspcurlloops = 0;
	if ($valwpsss !== false && $http_code == 200 || $http_code == 301 || $http_code == 302 || $http_code == 303)
	{
		if($valwpsss !== false && $http_code == 200)
		{
		$http_code = 301;
		$wpspfstart = stripos($content, "http-equiv=\"refresh\" content=\"0; url=&#39;");
		$wpspftmp = substr($content, $wpspfstart + strlen("http-equiv=\"refresh\" content=\"0; url=&#39;"));
		$wpspflen = stripos($wpspftmp, "&#39;\"");
		$rURL = substr($wpspftmp, 0, $wpspflen);
		if (stripos($rURL, "blogger.com") === false)
		{
			$wpsp_gpckarray = array();
		}
		}
		else
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
			$wpspcurlloops = 0;
			return $pmp_ocheck === true ? $content : $nsheader;
		}
		$wpsp_last_urlx = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		$wpsp_lasturl = @parse_url($wpsp_last_urlx);
		
		
		if (!(isset($url["scheme"])))
		{
			$url["scheme"] = $wpsp_lasturl["scheme"];
		}
		if (!(isset($url["host"])))
		{
			$url["host"] = $wpsp_lasturl["host"];
		}
		if (!$url["path"])
		{
			$url["path"] = $wpsp_lasturl["path"];
		}
		if (!(isset($url["query"])))
		{
			$url["query"] = "";
		}
		$new_url = $url["scheme"] . "://" . $url["host"] . $url["path"] . ($url["query"] ? "?" . $url["query"] : "");
		curl_setopt($ch, CURLOPT_URL, $new_url);
		return curlpagemanage($ch, $wpsp_last_urlx, false ,"", $wpspadvsettings);
		}
	}
	
	if($wpspcontentonly === true)
	{ 
		return $content;
	}
	else
	{ 
		return $nsheader;
	}
	
	$checkw="new";
}
function getcurlpagex($url, $reference = "", $wpspfieldsgp = "", $wpspadvsettings = "") 
{
	$ch = curl_init($url);
	$contents = curlpagemanage($ch, $reference, $wpspfieldsgp, $wpspadvsettings);
	curl_close($ch);
	return $contents;
}
function urlcheckongp($contenturl,$contentcnt)
{
	$googlesclink = "https://accounts.google.com/ServiceLoginAuth";
	$googlechspan = "<span color=\"red\">";
	$googlesecondvr = "google.com/SecondFactor";
	$googlesecondvr2 = "google.com/SmsAuth";
	$googlepolicy = "NewPrivacyPolicy";
	$googleserviceauto = "ServiceLoginAuth";
	$googlecaptcha = "CaptchaChallengeOptionContent";
	$googlecaptcha2 = "captcha-box";
	
	if ((stripos($contenturl, "https://accounts.google.com/ServiceLoginAuth") !== false) && (stripos($contentcnt, "<span color=\"red\">") !== false))
	{
		$wpspfstart4 = stripos($contentcnt, "<span color=\"red\">");
		$wpspftmp4 = substr($contentcnt, $wpspfstart4 + strlen("<span color=\"red\">"));
		$wpspflen4 = stripos($wpspftmp4, "</span>");
		return substr($wpspftmp4, 0, $wpspflen4);
	}
	if (stripos($contenturl, "google.com/SecondFactor") !== false || stripos($contenturl, "google.com/SmsAuth") !== false)
	{
		return "2-step verification in on so not ready for autopost.";	
	}
	if (stripos($contenturl, "NewPrivacyPolicy") !== false)
	{
		return "Please login to your account and accept New Privacy Policy";
	}
	if (stripos($contenturl, "ServiceLoginAuth") !== false)
	{
		return "The username or password you entered is incorrect" . $contents["errmsg"];
	}
	if (stripos($contentcnt, "CaptchaChallengeOptionContent") !== false || stripos($contentcnt, "captcha-box") !== false)
	{
		return "Captcha is \"On\" for your account. Please click here <a href=\"https://www.google.com/accounts/DisplayUnlockCaptcha\" target=\"_blank\">Click Here</a>";
	}
	
}
		
function conncetwithgoogleplus($email, $pass)
{
	global $wpsp_gpckarray;
	global $wpsp_gpckarrayBD;
	$wpsp_gpckarray = array();
	$wpspadvsettings = array();
	$md = array();
	$mids = "";
	$wpspgpflds = array();
	
	
	$err = wpspCheckSSLCurl("https://accounts.google.com/ServiceLogin");
	if ($err !== false && $err["errNo"] == "60")
	{
		$wpspadvsettings["noSSLSec"] = true;
	}
	$contents = checkdomaingp($servicegpurl,$wpspadvsettings);
	$inputfld = "<input";
	$inputname = "name=\"";
	$inputvalue = "value=\"";
	$signin = "Sign%20in";
	$hidden = "\"hidden\"";
	$googleaclink = "https://accounts.google.com/ServiceLoginAuth";
	$wpspgpflds["Email"] = $email;
	$wpspgpflds["Passwd"] = $pass;
	$wpspgpflds["signIn"] = $signin;
	while (stripos($contents, $inputfld) !== false)
	{
		$wpspfstart = stripos($contents, $inputfld);
		$wpspftmp = substr($contents, $wpspfstart + strlen($inputfld));
		$wpspflen = stripos($wpspftmp, ">");
		$tffch = substr($wpspftmp, 0, $wpspflen);
		$inpField = trim($tffch);
		
		$wpspfstart1 = stripos($inpField, $inputname);
		$wpspftmp1 = substr($inpField, $wpspfstart1 + strlen($inputname));
		$wpspflen1 = stripos($wpspftmp1, "\"");
		$tffch1 =  substr($wpspftmp1, 0, $wpspflen1);
		$name = trim($tffch1);
		if ((stripos($inpField, $hidden) !== false) && ($name != "") && !(in_array($name, $md)))
		{
			$md[] = $name;
			$wpspfstart2 = stripos($inpField, $inputvalue);
			$wpspftmp2 = substr($inpField, $wpspfstart2 + strlen($inputvalue));
			$wpspflen2 = stripos($wpspftmp2, "\"");
			$tffch2 =  substr($wpspftmp2, 0, $wpspflen2);
			$val = trim($tffch2);
			$wpspgpflds[$name] = $val;
			$mids .= "&" . $name . "=" . $val;
		}
		$contents = substr($contents, stripos($contents, $inputfld) + 8);
		continue;
	}
	
	$wpspquery_array = array();
	foreach ($wpspgpflds as $key => $value)
	{
		$wpspquery_array[] = $key . "=" . urlencode($value);
		continue;
	}
	$wpspgpfldsTxt = implode("&", $wpspquery_array);
	$wpspadvsettings["cdomain"] = "google.com";
	$contents = getcurlpagex($googleaclink, "", false, $wpspgpfldsTxt, $wpspadvsettings);
	
	return urlcheckongp($contents['url'],$contents['content']);
	return false;
}
function wpspgetlinkandtitle($url,$msg) 
{
	//$rnds = GeraHash(13);
	$url = urlencode($url);
	$contents = getcurlpagex("https://plus.google.com/", "", false);
	$wpspfstart7 = stripos($contents["content"], "csi.gstatic.com/csi\",\"");
	$wpspftmp7 = substr($contents["content"], $wpspfstart7 + strlen("csi.gstatic.com/csi\",\""));
	$wpspflen7 = stripos($wpspftmp7, "\",");
	$gpatvalue = substr($wpspftmp7, 0, $wpspflen7);
	$gurl = "https://plus.google.com/u/1/_/sharebox/linkpreview/?c=" . $url . "&t=1&slpf=0&ml=1&_reqid=1608303&rt=j";
	$wpspsprvl = "susp=false&at=" . $gpatvalue . "&";
	$contents = getcurlpagex($gurl, "", false, $wpspsprvl);
	$titlejson1 = substr($contents["content"], 5);
	$titlejson1 = str_replace(",{", ",{\"", $titlejson1);
	$titlejson1 = str_replace(":[", "\":[", $titlejson1);
	$titlejson1 = str_replace(",{\"\"", ",{\"", $titlejson1);
	$titlejson1 = str_replace("\"\":[", "\":[", $titlejson1);
	$titlejson1 = str_replace("[,", "[\"\",", $titlejson1);
	$titlejson1 = str_replace(",,", ",\"\",", $titlejson1);
	$titlejson1 = str_replace(",,", ",\"\",", $titlejson1);
	
	$json = $titlejson1;
	return posttitledisplaylist($json,$msg);
}
function postmsgcheck($msg)
{
	$msg = str_replace("<br>", "_wpspvlformsg", $msg);
	$msg = str_replace("<br/>", "_wpspvlformsg", $msg);
	$msg = str_replace("<br />", "_wpspvlformsg", $msg);
	$msg = str_replace("\r\n", "\n", $msg);
	$msg = str_replace("
\r", "\n", $msg);
	$msg = str_replace("\r", "\n", $msg);
	$msg = str_replace("\n", "_wpspvlformsg", $msg);
	$msg = str_replace("\"", "\\\"", $msg);
	$msg = urlencode(strip_tags($msg));
	$msg = str_replace("_wpspvlformsg", "%5Cn", $msg);
	$msg = str_replace("+", "%20", $msg);
	$msg = str_replace("%0A%0A", "%20", $msg);
	$msg = str_replace("%0A", "", $msg);
	$msg = str_replace("%0D", "%5C", $msg);
	return $msg;
}
function googlepluspostfromwpsp($pcontent,$images,$link,$domain,$title,$txt) 
{
	$new= '';
	$wpspownerid = "";
	$wpspbigcd = "";
	$titlereplce = array("\n", "\r");
	
	$pcontent =postmsgcheck($pcontent);
	
	if (isset($images) && trim($images) != "")
	{
		$img = getcurlpagex($images, "", false);
		if ($img["http_code"] == "200" && $img["content_type"] != "text/html")
		{
			$wpsppostlink["imgType"] = urlencode($img["content_type"]);
		}
		else 
		{
			$images = "";
		}
	}
	$images = urlencode($images);
	$link = urlencode($link);
	$domain = urlencode($domain);
	$title = str_replace($titlereplce, " ", $title);
		$title = rawurlencode(addslashes($title));
	$txt = str_replace($titlereplce, " ", $txt);
		$txt = rawurlencode(addslashes($txt));
	
	
	$contents = getcurlpagex("https://plus.google.com/", "", false);
	$wpspfstart8 = stripos($contents["content"], "key: '2'");
	$wpspftmp8 = substr($contents["content"], $wpspfstart8 + strlen("key: '2'"));
	$wpspflen8 = stripos($wpspftmp8, "]");
	$new = substr($wpspftmp8, 0, $wpspflen8);
	
	$wpspfstart9 = stripos($new, "https://plus.google.com/");
	$wpspftmp9 = substr($new, $wpspfstart9 + strlen("https://plus.google.com/"));
	$wpspflen9 = stripos($wpspftmp9, "\"");
	$new = substr($wpspftmp9, 0, $wpspflen9);
	
	$wpspfstart19 = stripos($contents["content"], "csi.gstatic.com/csi\",\"");
	$wpspftmp19 = substr($contents["content"], $wpspfstart19 + strlen("csi.gstatic.com/csi\",\""));
	$wpspflen19 = stripos($wpspftmp19, "\",");
	$gpatvalue = substr($wpspftmp19, 0, $wpspflen19);
	if (!(isset($txt)))
	{
		$txt = "";
	}
	$txttxt = $txt;
	$txtStxt = str_replace("%5C", "%5C%5C%5C%5C%5C%5C%5C", $txttxt);
	$proOrCommTxt = "%5D%2C%5B%5B%5Bnull%2Cnull%2C1%5D%5D%2Cnull";
	$refPage = "https://plus.google.com/b/" . $new . "/";
	$gpp = "https://plus.google.com/_/sharebox/post/?spam=20&_reqid=1608303&rt=j";
	if (isset($link) && trim($link) != "")
	{
		$wpsppostlinktitle = $title;
		$wpsppostlinktext = $txt;
		$wpsppostlinkdomain =$domain;
		$wpsppostlinkimg =$images;
		$wpsppostlinklink =$link;
		$wpspsprvl = linkwithmsgnew($pcontent,$new,$wpsppostlinktitle,$wpsppostlinktext,$wpsppostlinkdomain,$wpsppostlinkimg,$wpsppostlinklink,$wpsppostlinkimgType,$wpspownerid,$proOrCommTxt,$wpspbigcd,$gpatvalue);
	}
	$wpspsprvl = str_ireplace("+", "%20", $wpspsprvl);
	$wpspsprvl = str_ireplace(":", "%3A", $wpspsprvl);
	$contents = getcurlpagex($gpp, $refPage, false, $wpspsprvl);
	return print_r($contents, true);
}
function posttitledisplaylist($vljsn,$msg)
{
	
	$array = json_decode($vljsn, true);
	$lnkvl["link"]= $array[0][1][4][0][1];
	$lnkvl["fav"] = $array[0][1][4][0][2];
	$lnkvl["title"] = $array[0][1][4][0][3];
	$lnkvl["domain"] = $array[0][1][4][0][4];
	$lnkvl["txt"] = $array[0][1][4][0][5];
	list(, list(, , , , list(list(, , , , , , list(list(, , , , , , , , $lnkvl["img"])))))) = $array[0];
	list(, list(, , , , list(list(, , , , , , list(list(, $lnkvl["imgType"])))))) = $array[0];
	$lnkvl["title"] = str_replace("&#39;", "'", $lnkvl["title"]);
	$lnkvl["txt"] = str_replace("&#39;", "'", $lnkvl["txt"]);
	$lnkvl["txt"] = html_entity_decode($lnkvl["txt"]);
	$lnkvl["title"] = html_entity_decode($lnkvl["title"]);
	
	$title = $lnkvl["title"];
	$link =$lnkvl["link"];
	$domain =$lnkvl["domain"];
	$txt = $lnkvl["txt"];
	return googlepluspostfromwpsp($msg,$images,$link,$domain,$title,$txt);
	//return $out;		
}