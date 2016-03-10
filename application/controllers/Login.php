<?php
/**
 * Created by PhpStorm.
 * User: dongdong
 * Date: 16-3-9
 * Time: 下午7:27
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller{

    //载入视图
    public function index(){
       $this->load->view('register.html');
    }
    //获取提交的信息
    public function add(){

        $data=array(
            'username'=>$this->input->post('username'),
            'password'=>$this->input->post('password'),
            'email'=>$this->input->post('email'),
            'regtime'=>time(),
            'token'=>session_id()
        );
        //插入数据库操作
        $this->load->model('Admin_model','admin');
        $this->admin->add($data);

        /*
         * 发送邮件操作
         */
        $this->load->library('email');
        $emailbody = "亲爱的".$data['username']."：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/>
    <a href='http://localhost/b/login/check?token='".$data['token']." target=
'_blank'>http://localhost/b/login/check?token=".$data['token']."</a><br/>
    如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。";




        $this->email->from('wangdong95@126.com', 'star');
        $this->email->to($data['email']);
        $this->email->subject('邮箱激活通知');
        $this->email->message($emailbody);
        $this->email->send();
        echo $this->email->print_debugger();
    }

    public function check(){
        $token=$_GET['token'];
        $this->load->model('Admin_model','admin');
        $a=$this->admin->check($token);
        var_dump($a);

        //对比session值是否一致
        if($token==$a[0]['token'])
        {$data['status']=1;
            $uid=$a[0]['uid'];
            if($this->admin->change($data,$uid))
            {echo 'success';}
            else
                echo 'lose';
        }
        else
            echo '验证失败';

    }


}