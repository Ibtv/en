<?php



//产品 带分页

function sp_sql_produce_paged($arr,$pagesize=20,$pagetpl='{first}{prev}{liststart}{list}{listend}{next}{last}'){



	$where = array();



	$arr = sp_param_lable($arr);

	$field = !empty($arr['field']) ? $arr['field'] : '*';

	$limit = !empty($arr['limit']) ? $arr['limit'] : '';

	$order = !empty($arr['order']) ? $arr['order'] : 'id';



	if(isset($arr['mid'])){

		$where['mid']=array('in',$arr['mid']);

	}

	if(isset($arr['status'])){

		$where['status'] = array('eq',$arr['status']);

	}



	$obj = M("Produce");

	$rstsize = $obj -> field($field) -> where($where)->count();

	import('Page');

	if($pagesize == 0){

		$pagesize = 20;

	}



	$pageparam = C("VAR_PAGE");

	$page = new Page($rstsize,$pagesize);

	$page->setLinkWraper("li");

	$page->__set("PageParam",$pageparam);

	$page->SetPager('default',$pagetpl,array("listlong" => '8',"first" => "Home","last" => "Last Page","prev" => "Page Up","next" => "Page Down","list" => "*","disabledclass" => ""));
	$rst = $obj -> field($field) -> where($where) -> order($order) -> limit($page->firstRow . ',' . $page->listRows) -> select();

	$con['result'] = $rst;

	$con['page'] = $page->show("default");

	return $con;

}



//产品 不带分页

function sp_sql_produce($arr,$where=array()){

	if(!is_array($where)){

		$where = array();

	}



	$arr = sp_param_lable($arr);

	$field = !empty($arr['field']) ? $arr['field'] : '*';

	$limit = !empty($arr['limit']) ? $arr['limit'] : '';

	$order = !empty($arr['order']) ? $arr['order'] : 'id';



	if(isset($arr['mid'])){

		$where['mid']=array('in',$arr['mid']);

	}

	if(isset($arr['status'])){

		$where['status'] = array('eq',$arr['status']);

	}



	$obj = M("Produce");

	$rst = $obj -> field($field) -> where($where)->order($order)->limit($limit)->select();

	

	return $rst;

}



//根据用户id查找此会员下所有商品

function sp_sql_produce_byuserid($id){

	if($id){

		$obj = M("Produce");

		return $rst = $obj -> where("mid=$id") -> select();

	}else{

		$this->error("参数错误!");

	}

}



//会员 带分页

function sp_sql_approve_paged($arr,$pagesize=20,$pagetpl='{first}{prev}{liststart}{list}{listend}{next}{last}'){



	$where=array();



	$arr = sp_param_lable($arr);

	$field = !empty($arr['field']) ? $arr['field'] : '*';

	$limit = !empty($arr['limit']) ? $arr['limit'] : '';

	$order = !empty($arr['order']) ? $arr['order'] : 'id';



	$where['ustatus'] = array('eq',3);



	if(isset($arr['htypeid'])){

		$where['htypeid'] = array('in',$arr['htypeid']);

	}



	if(isset($arr['tuij'])){

		$where['tuij'] = array('eq',$arr['tuij']);

	}



	$model = M("Approve");

	$rstsize = $model -> field($field) -> where($where) -> count();



	import('Page');

	if($pagesize == 0){

		$pagesize =20;

	}

	$pageparam = C('VAR_PAGE');

	$page = new Page($rstsize,$pagesize);

	$page->setLinkWraper("li");

	$page->__set("PageParam",$pageparam);

	$page->SetPager('default',$pagetpl,array("listlong" => '8',"first" => "Home","last" => "Last Page","prev" => "Page Up","next" => "Page Down","list" => "*","disabledclass" => ""));

	$rst = $model -> field($field) ->where($where)->order($order)->limit($page->firstRow . ',' . $page->listRows)->select();



	$con['result'] = $rst;

	$con['page'] = $page->show('default');

	return $con;

}



//会员 不带分页

function sp_sql_approve($arr,$where=array()){

	if(!is_array()){

		$where=array();

	}



	$arr = sp_param_lable($arr);

	$field = !empty($arr['field']) ? $arr['field'] : '*';

	$limit = !empty($arr['limit']) ? $arr['limit'] : '';

	$order = !empty($arr['order']) ? $arr['order'] : 'id';



	$where['ustatus'] = array('eq',3);



	if(isset($arr['htypeid'])){

		$where['htypeid'] = array('in',$arr['htypeid']);

	}



	if(isset($arr['tuij'])){

		$where['tuij'] = array('eq',$arr['tuij']);

	}



	$model = M("Approve");

	$rst = $model -> field($field) -> where($where)->order($order)->limit($limit) -> select();



	return $rst;

}



//根据会员id查找此会员信息

function sp_sql_approve_bymemberid($id){

	if($id){

		$obj = M("Approve");

		$rst = $obj -> where("mid=$id") -> select();

		return $rst;

	}else{

		$this->error("参数错误!");

	}

}



//活动 不带分页

function sp_sql_mbersimg($arr,$where=array()){

	if(!is_array($where)){

		$where = arrar();

	}



	$arr = sp_param_lable($arr);

	$field = !empty($arr['field']) ? $arr['field'] : '*';

	$limit = !empty($arr['limit']) ? $arr['limit'] : '';

	$order = !empty($arr['order']) ? $arr['order'] : 'id';



	$obj = M("Mbersimg");

	$rst = $obj -> field($field) -> where($where) -> order($order) -> limit($limit) -> select();

	return $rst;



}



//活动 带分页

function sp_sql_mbersimg_paged($arr,$pagesize=20,$pagetpl='{first}{prev}{liststart}{list}{listend}{next}{last}'){



	$where = arrar();



	$arr = sp_param_lable($arr);

	$field = !empty($arr['field']) ? $arr['field'] : '*';

	$limit = !empty($arr['limit']) ? $arr['limit'] : '';

	$order = !empty($arr['order']) ? $arr['order'] : 'id';



	$obj = M("Mbersimg");

	$rstsize = $obj -> field($field) -> where($where) -> count();



	import('Page');

	if($pagesize == 0){

		$pagesize = 20;

	}

	$pageparam = C("VAR_PAGE");

	$page = new Page($rstsize,$pagesize);

	$page->setLinkWraper("li");

	$page->__set("PageParam",$pageparam);

	$page->SetPager("default",$pagetpl,array("listlong" => "10", "first" => "Home", "last" => "Last Page", "prev" => "Page Up", "next" => "Page Down", "list" => "*", "disabledclass" => ""));

	$rst = $obj->field($field)->where($where)->order($order)->limit($page->firstRow . ',' . $page->listRows) -> select();



	$con['result'] = $rst;

	$con['page'] = $page->show("default");



	return $con;

}



//消息 不带分页

function sp_sql_message($arr,$where=array()){

	if(!is_array($where)){

		$where = array();

	}



	$arr = sp_param_lable($arr);

	$field = !empty($arr['field']) ? $arr['field'] : '*';

	$limit = !empty($arr['limit']) ? $arr['limit'] : '';

	$order = !empty($arr['order']) ? $arr['order'] : 'id';



	$obj = M("Message");

	$rst = $obj -> field($field) -> where($where) -> order($order) -> limit($limit) -> select();

	return $rst;



}



//消息 带分页

function sp_sql_message_paged($arr,$pagesize=20,$pagetpl='{first}{prev}{liststart}{list}{listend}{next}{last}'){



	$where = array();



	$arr = sp_param_lable($arr);

	$field = !empty($arr['field']) ? $arr['field'] : '*';

	$limit = !empty($arr['limit']) ? $arr['limit'] : '';

	$order = !empty($arr['order']) ? $arr['order'] : 'id';



	$obj = M("Message");

	$rstsize = $obj -> field($field) -> where($where) -> count();



	import('Page');

	if($pagesize == 0){

		$pagesize = 20;

	}



	$pageparam = C("VAR_PAGE");

	$page = new Page($rstsize,$pagesize);

	$page->setLinkWraper("li");

	$page->__set("PageParam",$pageparam);

	$page->SetPager("default",$pagetpl,array("listlong" => "10", "first" => "Home", "last" => "Last Page", "prev" => "Page Up", "next" => "Page Down", "list" => "*", "disabledclass" => ""));

	$rst = $obj->field($field)->where($where)->order($order)->limit($page->firstRow . ',' . $page->listRows)->select();



	$con['result'] = $rst;

	$con['page'] = $page->show("default");



	return $con;

}