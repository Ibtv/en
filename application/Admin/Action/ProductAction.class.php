<?php
//会员相关，所涉及的验证问题今后维护添加，比如邮箱，电话等；由靳思远（以后简称J_SY）开发2014-10.5
class ProductAction extends AdminbaseAction {

   public function update() {
        $Id = $_POST['id'];
        unset($_POST['id']);
        $data = $_POST;
        $data['pimg'] = $this->proimg();
        $data['updatetime'] = date("Y-m-d H:i:s");
        $Db = M('produce')->where('id='.$Id)->save($data);
        if ($Db) {
            $this->success('修改商品成功!');
        } else {
            $this->error('修改商品失败!');
        }
    }
    
   public function recommend(){
          $id = intval($GET_['id']);
           if($id){
             if(M("Produce") -> where(array("id" => $id)) -> setField("status","1")){
              $this->success("推荐成功!");
             }else{
              $this->error("推荐失败！");
             }
           }else{
            $this -> error("参数错误");
           }
        }

    public function proimg(){
        if (!is_uploaded_file($_FILES["img"]['tmp_name'])) {
            return '';
        }

        $path = SITE_PATH . '/upload/';
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
            $img = '/upload/' . $today . $type;

            $result = move_uploaded_file($_FILES["img"]["tmp_name"], $file2);
            return $img;
        } else {
            return '';
        }
    }

    public function productlist(){

    	$l = M("produce");
    	$list = $l -> select();

    	$this -> assign('lists',$list);
    	$this->display();
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = intval(I("get.id"));
            //$data['status']=0;
            $pro = M("produce");
            if ($pro->where("id=$id")->delete()) {
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
    	$pro = M("produce")->where("id=$id")->find();

        $mn = $pro['mname'];
        $mid = M("Approve")->where("mname='$mn'")->getField('id');
        $mns = M("Approve")->select();
        $this->assign('pros',$pro);
    	$this->assign('mid',$mid);
        $this->assign('mns',$mns);
    	$this->display();
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
