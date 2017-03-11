<?php

/**
 * 搜索结果页面
 */
//namespace Portal\Action;
//use Common\Action\HomeBaseAction;
class SearchAction extends HomeBaseAction {
    //文章内页
    public function index() {
    	$_GET = array_merge($_GET, $_POST);
		$k = I("get.keyword");
		
		if (empty($k)) {
			$this -> error("关键词不能为空！请重新输入！");
		}
		$this -> assign("keyword", $k);
		$this -> display(":search");
    }
    
    
}
?>
