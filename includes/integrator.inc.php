<?php
if (!function_exists('wj_integrator_tags')) {
	function wj_integrator_tags($buffer,$prefix) {
		//page header & footer
		$tagslist='head';
		$tags=explode(',',$tagslist);
		foreach ($tags as $tag)
		{
			$buffer=str_replace('<'.$tag,'<!--'.$tag.':start--><div id="'.$prefix.$tag.'"',$buffer);
			$buffer=str_replace($tag.'>','div><!--'.$tag.':end-->',$buffer);
		}
		$buffer=str_replace('<body','<!--body:start--><div class="'.$prefix.'body"',$buffer);
		$buffer=str_replace('body>','div><!--body:end-->',$buffer);

		$buffer=preg_replace('/<html.*>/','<!--html:start-->',$buffer);
		$buffer=preg_replace('/<.html>/','<!--html:end-->',$buffer);
		$buffer=preg_replace('/<meta.*>/','<!--meta-->',$buffer);
		$buffer=preg_replace('/<title>.*<.title>/','<!--title-->',$buffer);
		$buffer=preg_replace('/<.DOCTYPE.*>/','<!--doctype-->',$buffer);
		return $buffer;
	}
}
if (!function_exists('wj_integrator_cut')) {
	function wj_integrator_cut(&$buffer,$stag,$etag,$between=true) {
		$cutout="";
		if ($buffer && $before=wj_strstr($buffer,$stag,true)) {
			$i=wj_strstr($buffer,$stag,false);
			$cutout=wj_strstr(substr($i,strlen($stag)),$etag,true);
			$after=wj_strstr($i,$etag,false);
			$buffer=$before.substr($after,strlen($etag));
			if (!$between) {
				$cutout=$stag.$cutout.$etag;
			}
		}
		return $cutout;
	}
}
if (!function_exists('wj_integrator_replace')) {
	function wj_integrator_replace(&$buffer,$stag,$etag,$replace) {
		$cutout="";
		if ($buffer && $before=wj_strstr($buffer,$stag,true)) {
			$i=wj_strstr($buffer,$stag,false);
			$cutout=wj_strstr(substr($i,strlen($stag)),$etag,true);
			$after=wj_strstr($i,$etag,false);
			$buffer=$before.$replace.substr($after,strlen($etag));
		}
		return $cutout;
	}
}
if (!function_exists('wj_strstr')) {
	function wj_strstr($haystack, $needle, $before_needle=FALSE) {
		//Find position of $needle or abort
		if(($pos=strpos($haystack,$needle))===FALSE) return FALSE;
		if ($before_needle) {
			if ($pos==0) return true;
			return substr($haystack,0,$pos);
		}
		else return substr($haystack,$pos);
	}
}
?>