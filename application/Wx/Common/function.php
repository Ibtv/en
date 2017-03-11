<?php
/*
 * 使用动态缓存机制
* 获取 设置config表中的key-value值
*/
function wx_val($key,$value=null){
	if(is_string($key) && is_null($value)){
		$data=M("WxConfig")->getField("key,value");
		//$data=v_cache();
		return $data[$key];
	}else if(is_string($value)){
		M("WxConfig")->where("key='{$key}'")->setField('value',$value);
		//$data=v_cache(true);
	}else if(is_array($key)){
		//批量赋值
		foreach($key as $k=>$v){
			M("WxConfig")->where("key='{$k}'")->setField('value',$v);
		}
		//$data=v_cache(true);
	}
}

/*
 * 辅助V方法完成key-value的动态缓存
* $bool表是否重新缓存
*/
function v_cache($bool){
	$rst=F('v_cache');
	if(empty($rst) || $bool){
		$data=M("WxConfig")->getField("key,value");
		F('v_cache',$data);
		return $data;
	}else{
		return $rst;
	}
}