<?php
//会员相关，所涉及的验证问题今后维护添加，比如邮箱，电话等；由靳思远（以后简称J_SY）开发2014-10.5
class ProductAction extends MemberbaseAction {

  protected $produce_model;

  function _initialize() {
    parent::_initialize();
    $this->produce_model=D("Produce");
  }

  public function test(){
    //$test = M('Produce','i_','mysql://root:ibtv_rootmysql@localhost/ibtv_cmf');
    $test = M("ibtv_cmf.Produce","i_");
    $list = $test -> limit(5) -> select();
    dump($list);

    $this->display(":test");
  }

  //会员产品添加
  public function addprod(){
    $userid = sp_get_current_userid();
    if(M("Approve")->where(array("mid"=>$userid,"ustatus"=>3))->find()){
      $this->display(":addprod");
    }else{
      $this->error("请您提交认证信息或者联系客服人员为您确认审核！",U("Product/approve"));
    }
  }

  //这里处理产品的添加
  public function addact(){
    if(isset($_POST)){
      $userid = sp_get_current_userid();
      $_POST['mname'] = M("Approve")->where("mid=$userid")->getField("mname");
      $_POST['mid'] = $userid;
      $img = "img";
      $_POST['pimg'] = $this-> proimg($img);//自定义的图片上传函数
      $_POST['createtime'] = date("Y-m-d H:i:s");
      if($this->produce_model -> add($_POST)){
        $this -> success('添加产品成功!');

      }else{
        $this -> error('添加产品失败!');
      }
    }else{
      $this->error('参数错误!');
    }
  }

  public function listprod(){
    $userid = sp_get_current_userid();
    $listprod = $this->produce_model->where("mid='$userid'")->select();
    $this->assign('listprod',$listprod);
    $this->display(":listprod");
  }

  public function approve(){
    $userid = sp_get_current_userid();
    if($rst = M("Approve")->where("mid=$userid")->find()){
      //dump($rst);
      if($rst['ustatus'] == 2){
        $this->display(":toaudit");
      }else{
        $this->display(":alreadyaudit");
      }
    }else{
      $this->display(":approve");
    }
  }

  public function appd(){
    $userid = sp_get_current_userid();
    if(isset($_POST)){
      $_POST['mid'] = $userid;
      $htypeid = $_POST['htypeid'];
      $htypename = M("hyecat")->where("id=$htypeid")->find();
      $img2 = "img";$img3 = "img1";$img4 = "img2";$img5 = "img3";$img6 = "img4";
      $_POST['htypename']=$htypename['hname'];
      $_POST['license'] = $this->proimg($img2);
      $_POST['mletter'] = $this->proimg($img3);
      $_POST['othero'] = $this->proimg($img4);
      $_POST['othert'] = $this->proimg($img5);
      $_POST['mlogo'] = $this->proimg($img6);
      $_POST['createtime'] = date("Y-m-d H:i:s");
      if(M("approve")->add($_POST)){
        $this->success('恭喜您,提交成功!');
      }else{
        $this->error('很遗憾,申请失败!');
      }
    }
  }

  public function update() {
    $Id = $_POST['id'];
    unset($_POST['id']);
    $data = $_POST;
    $img = "img";
    $data['pimg'] = $this->proimg($img);
    $data['updatetime'] = date("Y-m-d H:i:s");
    $Db = $this->produce_model->where('id='.$Id)->save($data);
    if ($Db) {
      $this->success('修改商品成功!');
    } else {
      $this->error('修改商品失败!');
    }
  }

  public function updateintro(){
    $userid = sp_get_current_userid();
    if($userid){
      $rst = M("Approve")->where("mid=$userid")->find();
      $this->assign('rst',$rst);
    }
    $this->display(":updateintro");
  }

  public function updateact(){
    if(isset($_POST)){
      $userid = sp_get_current_userid();
      if($userid){
        $rst = M("Approve")->where(array("mid"=>$userid))->save($_POST);
        if($rst){
          $this->success('上传成功！');
        }else{
          $this->error("上传失败！");
        }
      }else{
        $this->error("参数错误！");
      }
    }else{
      $this->error("参数错误！");
    }
  }

  //此处以后验证函数优化
  public function proimg($img1){
    if (!is_uploaded_file($_FILES["$img1"]['tmp_name'])) {
      return '';
    }

    $path = SITE_PATH . '/data/shop/';
    $tp = array("image/gif", "image/pjpeg", "image/jpeg", "image/png", "image/jpg");

    if (in_array($_FILES["$img1"]["type"], $tp)) {

      if (!in_array($_FILES["$img1"]["type"], $tp)) {
        return '';
      }
      $filetype = $_FILES["$img1"]['type'];
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
      $file2 = $path . $today . "license" . $type;
      $img = '/data/shop/' . $today . "license" . $type;

      $result = move_uploaded_file($_FILES["$img1"]["tmp_name"], $file2);
      return $img;
    } else {
      return '';
    }
  }

  public function delete() {
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      if ($this->produce_model->where("id=$id")->delete()) {
        $this->success("删除成功！");
      } else {
        $this->error("删除失败！");
      }
    }else{
      $this->error("参数错误!");
    }
  }

  public function edit(){
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      $pro = $this->produce_model->where("id=$id")->find();
      $this->assign('pros',$pro);
      $this->display(":edit");
    }else{
      $this->error("参数错误!");
    }
  }

  public function show(){
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      $p = M("produce");
      $pro = $p->where("id=$id")->find();
      $this->assign('pros',$pro);
      $this->display();
    }else{
      $this->error('参数错误!');
    }
  }

}
