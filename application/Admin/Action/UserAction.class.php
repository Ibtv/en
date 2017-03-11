<?php
class UserAction extends AdminbaseAction{
	protected $users_obj,$role_obj;
	protected $users_obj_es,$users_obj_fr,$users_obj_pt,$users_obj_ru,$users_obj_ar,$users_obj_de,$users_obj_kr,$users_obj_tw,$users_obj_cmf;
	function _initialize() {
		parent::_initialize();
		$this->users_obj = D("Users");
		$this->users_obj_es = D("ibtv_es.Users","i_");
		$this->users_obj_fr = D("ibtv_fr.Users","i_");
		$this->users_obj_pt = D("ibtv_pt.Users","i_");
		$this->users_obj_ru = D("ibtv_ru.Users","i_");
		$this->users_obj_ar = D("ibtv_ar.Users","i_");
		$this->users_obj_de = D("ibtv_de.Users","i_");
		$this->users_obj_kr = D("ibtv_kr.Users","i_");
		$this->users_obj_tw = D("ibtv_tw.Users","i_");
		$this->users_obj_cmf = D("ibtv_cmf.Users","i_");
		$this->role_obj = D("Role");
	}

	
	function index(){
		$users=$this->users_obj->where(array("user_type"=>1))->select();
		$roles_src=$this->role_obj->select();
		$roles=array();
		foreach ($roles_src as $r){
			$roleid=$r['id'];
			$roles["$roleid"]=$r;
		}
		$this->assign("roles",$roles);
		$this->assign("users",$users);
		$this->display();
	}
	
	
	function add(){
		$roles=$this->role_obj->where("status=1")->select();
		$this->assign("roles",$roles);
		$this->display();
	}

	function add_post(){
		if(IS_POST){
			$en = $this->users_obj->create();
			$_POST['user_pass'] = sp_password(I("post.user_pass"));
			$es = $this->users_obj_es->create();
			$fr = $this->users_obj_fr->create();
			$pt = $this->users_obj_pt->create();
			$ru = $this->users_obj_ru->create();
			$ar = $this->users_obj_ar->create();
			$de = $this->users_obj_de->create();
			$kr = $this->users_obj_kr->create();
			$tw = $this->users_obj_tw->create();
			$cmf = $this->users_obj_cmf->create();
			if($en && $es && $fr && $pt && $ru && $ar && $de && $kr && $tw && $cmf){
				if($this->users_obj->add()!==false && $this->users_obj_es->add()!==false && $this->users_obj_fr->add()!==false && $this->users_obj_pt->add()!==false && $this->users_obj_ru->add()!==false && $this->users_obj_ar->add()!==false && $this->users_obj_de->add()!==false && $this->users_obj_kr->add()!==false && $this->users_obj_tw->add()!==false && $this->users_obj_cmf->add()!==false){
					$this->success("添加成功!",U("user/index"));
				}else{
					$this->error("添加失败!");
				}
			}else{
				$this->error($this->users_obj->getError());
			}

		}
	}
	
	
	function edit(){
		$id= intval(I("get.id"));
		$roles=$this->role_obj->where("status=1")->select();
		$this->assign("roles",$roles);
			
		$user=$this->users_obj->where(array("id"=>$id))->find();
		$this->assign($user);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if(empty($_POST['user_pass'])){
				unset($_POST['user_pass']);
			}
			$en = $this->users_obj->create();
			$_POST['user_pass'] = sp_password(I("post.user_pass"));
			$es = $this->users_obj_es->create();
			$fr = $this->users_obj_fr->create();
			$pt = $this->users_obj_pt->create();
			$ru = $this->users_obj_ru->create();
			$ar = $this->users_obj_ar->create();
			$de = $this->users_obj_de->create();
			$kr = $this->users_obj_kr->create();
			$tw = $this->users_obj_tw->create();
			$cmf = $this->users_obj_cmf->create();
			if ($en && $ar && $es && $fr && $pt && $ru && $de && $kr && $tw && $cmf) {
				$result=$this->users_obj->save();
				$es = $this->users_obj_es->save();
				$fr = $this->users_obj_fr->save();
				$pt = $this->users_obj_pt->save();
				$ru = $this->users_obj_ru->save();
				$ar = $this->users_obj_ar->save();
				$de = $this->users_obj_de->save();
				$kr = $this->users_obj_kr->save();
				$tw = $this->users_obj_tw->save();
				$cmf = $this->users_obj_cmf->save();
				if ($result!==false && $es!==false && $fr!==false && $pt!==false && $de!==false && $ar!==false && $ru!==false && $kr!==false && $tw!==false && $cmf!==false) {
					$this->success("保存成功！");
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->users_obj->getError());
			}
		}
	}
	
	/**
	 *  删除
	 */
	function delete(){
		$id = intval(I("get.id"));
		if($id==1){
			$this->error("最高管理员不能删除！");
		}
		
		if ($this->users_obj->where("id=$id")->delete()!==false && $this->users_obj_es->where("id=$id")->delete()!==false && $this->users_obj_fr->where("id=$id")->delete()!==false && $this->users_obj_pt->where("id=$id")->delete()!==false && $this->users_obj_ru->where("id=$id")->delete()!==false && $this->users_obj_ar->where("id=$id")->delete()!==false && $this->users_obj_de->where("id=$id")->delete()!==false && $this->users_obj_kr->where("id=$id")->delete()!==false && $this->users_obj_tw->where("id=$id")->delete()!==false && $this->users_obj_cmf->where("id=$id")->delete()!==false) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	
	
	function userinfo(){
		$id=get_current_admin_id();
		$user=$this->users_obj->where(array("id"=>$id))->find();
		$this->assign($user);
		$this->display();
	}
	
	function userinfo_post(){
		if (IS_POST) {
			if ($this->users_obj->create()) {
				if ($this->users_obj->save()!==false) {
					$this->success("保存成功！");
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->users_obj->getError());
			}
		}
	}
		
}