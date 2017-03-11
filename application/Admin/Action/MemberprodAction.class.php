<?php
//会员产品处理页面
class MemberprodAction extends HomeBaseAction {

//以后整合到一个二维数组，现在不做优化；由靳思远（以后简称J_SY）开发2014-10.5
//前端模板输出头部没有放入Public内，待优化！
	public function more(){

		$mb = M('member');
		$nlmy = $mb -> where('hyecat=1') -> select();
		$ckzz = $mb -> where('hyecat=2') -> select();
		$drrq = $mb -> where('hyecat=3') -> select();
		$jzfc = $mb -> where('hyecat=4') -> select();
		$pfls = $mb -> where('hyecat=5') -> select();
		$rjxx = $mb -> where('hyecat=6') -> select();
		$wtyl = $mb -> where('hyecat=7') -> select();
		$gjzz = $mb -> where('hyecat=8') -> select();

		$newprolist = M("produce")->limit(6)->order('id desc')->select();
		$rehyelist = M("hyecat")->limit(6)->select();
		$tuiprolist = M("produce")->where('status=1')->order("id desc")->limit(3)->select();
		$tuimember = $mb->where('status=1')->order("id desc")->limit(4)->select();
		$newmember = $mb->limit(6)->order('id desc')->select();
		$newmsg = M('message')->order('id desc')->limit(5)->select();
		$tuimsg = M('message')->where('status=1')->limit(6)->select();

		$wuflist = M("mbersimg")->order("id desc")->limit(5)->select();

		$this -> assign('nlmy',$nlmy);
		$this -> assign('ckzz',$ckzz);
		$this -> assign('drrq',$drrq);
		$this -> assign('jzfc',$jzfc);
		$this -> assign('pfls',$pfls);
		$this -> assign('rjxx',$rjxx);
		$this -> assign('wtyl',$wtyl);
		$this -> assign('gjzz',$gjzz);
		$this -> assign('prolist',$newprolist);
		$this -> assign('rehyelist',$rehyelist);
		$this -> assign('tuiprolist',$tuiprolist);
		$this -> assign('tuimember',$tuimember);
		$this -> assign('newmember',$newmember);
		$this -> assign('newmsg',$newmsg);
		$this -> assign('tuimsg',$tuimsg);
		$this -> assign('wuflist',$wuflist);
		$this -> display(":index");
	}

	public function all(){

		$mm = M('member');
		$allm = $mm->select();
		$tuimember = $mm->where("status=1")->select();
		$tuimessage=M("message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('allm',$allm);
		$this->assign('tuimember',$tuimember);
		$this->display(":all");
	}

	public function allprod(){

		$pro = M("produce");
		$allprod = $pro->select();
		$tuiprod = $pro -> where("status=1")->limit(6)->select();
		$tuimessage=M("message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('allprod',$allprod);
		$this->assign('tuiprod',$tuiprod);
		$this->display(":allprod");
	}

	public function memberinfo(){
		$id = $_GET['id'];
		$m = M("member");
		if($id){
		$mb = $m -> where("id=$id")->find();
		}elseif($_GET['mn']){
		$mn = $_GET['mn'];
		$mb = $m -> where("mname='$mn'") -> find();	
		}

		$mm = $mb['mname'];
		$mpro = M("produce")->where("mname='$mm'")->select();
		$tuimessage=M("message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('mb',$mb);
		$this->assign('mpro',$mpro);
		$this->display(":memberinfo");
	}

	public function productinfo(){
		$id = $_GET['id'];
		$pro = M("produce")->where("id=$id")->find();
		$mn = $pro['mname'];
		$mns = M("member")->where("mname='$mn'")->find();
		$tuimessage=M("message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('pro',$pro);
		$this->assign('mns',$mns);
		$this->display(":productinfo");
	}

	public function activity(){
		$m = M("mbersimg");
		$hd = $m -> order("id desc")->select();
		$tuimessage=M("message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('hd',$hd); 
		$this->display(":activity");
	}

	public function activityinfo(){
		$id = $_GET['id'];
		$m = M("mbersimg");
		$hd = $m -> where("id=$id")->find();
		$tuimessage=M("message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('hd',$hd);
		$this->display(":activityinfo");
	}

	public function allmsg(){
		$m = M("message");
		$mls = $m -> order("id desc") -> select();
		$tuimsg = $m -> where("status=1") ->limit(6) -> select();
		$tuimember = M("member") -> where("status=1") -> select();
		$tuiprod = M("produce") -> where("status=1") -> select();

		$this->assign('mls',$mls);
		$this->assign("tuimessage",$tuimsg);
		$this->assign("tuimember",$tuimember);
		$this->assign("tuiprod",$tuiprod);
		$this->display(":allmsg");		
	}

	public function infoinfo(){
		$id = $_GET['id'];
		$m = M("message");
		$sm = $m -> where("id=$id") -> find();
		$tuimessage=M("message")->where("status=1")->select();

		$this->assign('tuimessage',$tuimessage);
		$this->assign('sm',$sm);
		$this->display(":infoinfo");
	}

	public function search(){
		
		$typ = $_POST['type'];
		if($typ ==0){
			$pname = $_POST['sear'];
			$m = M("produce");
			$where['pname'] = array('like','%'.$pname.'%');
			$search = $m -> where('"pname" like %$pname%') -> select();
			if(empty($search)){
				$arr['name']="没有搜索到符合条件的结果!";
				$this->assign('arr',$arr);
			}
			
		}elseif($typ==1){
			$mname = $_POST['sear'];
			$m = M("member");
			$where['mname'] = array('like','%'.$mname.'%');
			$search = $m -> where($where) -> select();
			$tuimember = $m -> where("status=1")->select();
			$this->assign("tuimsg",$tuimember);
			if(empty($search)){
				$arr['name']='没有搜索到符合条件的结果!';
				$this->assign('arr',$arr);
			}
		}
		$n = M("message");
		$tuimg = $n -> where("status=1")->select();

		$this->assign('tuimessage',$tuimg);
		$this->assign('tuimsg',$tuimember);
		$this->assign("search",$search);
		$this->display(":search");
	}

	public function nlmy(){

		$list = M("member")->where("hyecat=1")->select();
		if($list){
			echo json_encode($list);
		}else{
			echo '{"info":"此行业暂无会员!"}';
		}
	}

	public function ckzz(){

		$list = M('member')->where('hyecat=2')->select();
		if($list){
			echo json_encode($list);
		}else{
			echo '{"info":"此行业暂无会员!"}';
		}
	}

	public function drrq(){
		$list = M('member')->where('hyecat=3')->select();
		if($list){
			echo json_encode($list);
		}else{
			echo '{"info":"此行业暂无会员!"}';
		}
	}

	public function jzfc(){
		$list = M('member')->where('hyecat=4')->select();
		if($list){
			echo json_encode($list);
		}else{
			echo '{"info":"此行业暂无会员!"}';
		}
	}

	public function pfls(){
		$list = M('member')->where('hyecat=5')->select();
		if($list){
			echo json_encode($list);
		}else{
			echo '{"info":"此行业暂无会员!"}';
		}
	}

	public function rjxx(){
		$list = M('member')->where('hyecat=6')->select();
		if($list){
			echo json_encode($list);
		}else{
			echo '{"info":"此行业暂无会员!"}';
		}
	}

	public function wtyl(){
		$list = M('member')->where('hyecat=7')->select();
		if($list){
			echo json_encode($list);
		}else{
			echo '{"info":"此行业暂无会员!"}';
		}
	}

	public function gjzz(){
		$list = M('member')->where('hyecat=8')->select();
		if($list){
			echo json_encode($list);
		}else{
			echo '{"info":"此行业暂无会员!"}';
		}
	}
}