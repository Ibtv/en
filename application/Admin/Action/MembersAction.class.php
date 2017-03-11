<?php
class MembersAction extends AdminbaseAction {
  //会员处理页面,所涉及的验证问题今后维护添加，比如邮箱，电话，还有从表单接受到的数据（id）等；由靳思远（以后简称J_SY）开发2014-10.3

  protected $Members_model;

  function _initialize() {
    parent::_initialize();
    $this->members_model = D("Approve");
  }
  //以下有的使用属性名，有的使用原始的方法创建的对象，以后优化！
  public function addm(){

    $this->display();
  }

  public function addact(){
    echo "<meta http-equiv='Content-Type' content='text/html;charset='utf8'/>";
    $data = $_POST;
    $id = $_POST['hyecat'];
    $hname = M("hyecat") -> where("id=$id")->find();
    $data['hangye'] = $hname['hname']; 
    $data['mlogo'] = $this -> proimg();
    $data['createtime'] = date("Y-m-d H:i:s");
    if(M("member")->add($data)){
      $this->success("添加成功!");
    }else{
      $this->error("添加失败!");
    }

  }

  public function memberslist(){
    $mem = M("Approve")->where("ustatus=3")->order("id desc")->select();

    $this -> assign('mem',$mem);
    $this -> display();

  }

  public function edit(){

    $id = $_GET['id'];
    $mm = M('approve')->where("id=$id")->find();
    $this->assign('mm',$mm);
    $this->display();
  }

  public function update(){

    $id = $_POST['id'];
    $data = $_POST;
    $hid = $_POST['htypeid'];
    $hname = M("hyecat") -> where("id=$hid")->find();
    $data['htypename'] = $hname['hname']; 
    $data['mlogo'] = $this->proimg();
    $data['updatetime'] = date("Y-m-d H:i:s");
    if(M("Approve")->where("id=$id")->save($data)){
      $this->success("修改成功!");
    }else{
      $this->error("修改失败!");
    }
  }

  public function delete(){
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      if(M("approve")->where("id=$id")->delete()){
        $this -> success("删除成功!");
      }else{
        $this -> error("删除失败!");
      }
    }else{
      $this -> error("参数错误!");
    }
  }

  public function addwuf(){
    $m = M("users");
    $mlist = $m -> select();

    $this -> assign('mlist',$mlist);
    $this->display();
  }

  public function addimgact(){

    $data = $_POST;
    $data['simg'] = $this -> proimg();
    $data['createtime'] = date("Y-m-d H:i:s");
    if(M("mbersimg")->add($data)){
      $this->success('添加成功!');
    }else{
      $this->error("添加失败!");
    }
  }

  public function editsimg(){
    $id = $_GET['id'];
    $ls = M("mbersimg")->where("id=$id")->find();
    $m = M("member");
    $mlist = $m -> select();

    $this -> assign('mlist',$mlist);
    $this->assign('ls',$ls);
    $this->display();
  }

  public function wuflist(){
    $list = M("mbersimg")->select();
    $this->assign('list',$list);
    $this->display();
  }

  public function updatesimg(){
    $data = $_POST;
    $data['simg'] = $this->proimg();
    $data['updatetime']=date("Y-m-d H:i:s");
    $id = $_POST['id'];
    if(M("mbersimg")->where("id=$id")->save($data)){
      $this->success("修改成功!");
    }else{
      $this->error("修改失败!");
    }
  }

  public function deletesimg(){
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      if(M("mbersimg")->where("id=$id")->delete()){
        $this->success("删除成功!");
      }else{
        $this->error("删除失败!");
      }
    }else{
      $this->error("参数错误!");
    }

  }

  public function toaudit(){
    $mem = M("Approve")->where("ustatus=2")->order("id desc")->select();
    $this->assign('mem',$mem);
    $this->display();
  }

  //查看提交审核的信息
  public function toview(){
    $id = intval($_GET['id']);
    $msg = M("Approve")->where("id=$id")->find();
    $this->assign('msg',$msg);
    $this->display();
  }

  //目前approve数据表里的utype字段暂无作用，ustatus字段表示是否确定会员通过与否。
  public function passaudit(){
    $id = intval($_GET['id']);
    $mid = intval($_GET['mid']);
    if($id){
      $rst = M("Users")->where(array("id"=>$mid,"user_type"=>2))->setField("user_status","3");
      $rst1 = M("Approve")->where(array("id"=>$id,"utype"=>2))->setField("ustatus","3");
      if($rst&$rst1){
        $this->success('通过审核!');
      }else{
        $this->error('审核失败!');
      }
    }else{
      $this->error("参数错误!");
    }
  }

  public function cancelaudit(){
    $id = intval($_GET['id']);
    $mid = intval($_GET['mid']);
    if($id){
      $rst=M("Users")->where(array("id"=>$mid,"user_type"=>"2"))->setField("user_status","1");
      $rst1=M("Approve")->where(array("id"=>$id,"utype"=>"2"))->setField("ustatus","2");
      if($rst&$rst1){
        $this->success("操作成功！");
      }else{
        $this->error("操作失败！");
      }
    }else{
      $this->error("参数错误!");
    }

  }

  public function tuij(){
    $mid = intval($_GET['mid']);
    if($mid){
      $rst = $this->members_model->where(array("mid"=>$mid))->setField("tuij","1");
      if($rst){
        $this->success("操作成功！");
      }else{
        $this->error("操作失败！");
      }
    }else{
      $this->error("参数错误！");
    }
  }

  public function proimg() {
    if (!is_uploaded_file($_FILES["img"]['tmp_name'])) {
      return '';
    }

    $path = SITE_PATH . '/data/shop/';
    $tp = array("image/gif", "image/pjpeg", "image/jpeg", "image/png", "image/jpg");


    if (in_array($_FILES["img"]["type"], $tp)) {

      if (!in_array($_FILES["img"]["type"], $tp)) {
        return '';
      }
      $filetype = $_FILES['img']['type'];
      if ($filetype == 'image/png') {
        $type = '.png';
      }
      if ($filetype == 'image/jpeg') {
        $type = '.jpg';
      }
      if ($filetype == 'image/jpg') {
        $type = '.jpg';
      }
      if ($filetype == 'image/pjpeg') {
        $type = '.jpg';
      }
      if ($filetype == 'image/gif') {
        $type = '.gif';
      }

      $today = date('YmdHis');
      $file2 = $path . $today . $type;
      $img = '/data/shop/' . $today . $type; 

      $result = move_uploaded_file($_FILES["img"]["tmp_name"], $file2);
      return $img;
    } else {
      return '';
    }
  }
}
