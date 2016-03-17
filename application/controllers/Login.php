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
        $this->load->model('Admin_model', 'admin');
        $this->load->library('email');
        $error[] = '';

        //xss clean and verify whether the data is valid
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $password = sha1(md5($password));
        $email = $this->security->xss_clean($this->input->post('email'));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $error[] = "plz fill in the correct email address";
        }
        //set time zone and format time
        date_default_timezone_set('Asia/Shanghai');
        $reg_time = date('F j Y h:i:s A');

        //make a token
        $token = sha1(session_id().$password);

        $data = array(
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'regtime' => $reg_time,
            'token' => 杀$token
        );

        $this->admin->check_new($data, $error);


        if (!empty($error))
        {
            var_dump($error);
        }
        else {
            //insert into database
            $this->admin->add($data);

            //send the email
            $emailbody = "亲爱的" . $data['username'] . "：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/>
        <a href='http://localhost:5555/login/check?token='" . $data['token'] . " target=
    '_blank'>http://localhost:5555/login/check?token=" . $data['token'] . "</a><br/>
        如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。";


            $this->email->from('wangdong95@126.com', 'star');
            $this->email->to('tzzmain@qq.com');
            $this->email->subject('邮箱激活通知');
            $this->email->message($emailbody);
            $this->email->send();
            echo $this->email->print_debugger();

            echo '注册成功';
        }
    }

    public function check(){
        $token=$_GET['token'];
        $this->load->model('Admin_model','admin');
        $a=$this->admin->check($token);
        echo "status:".$a[0]["status"];
        echo '<br />';

        //对比session值是否一致 && 是否已经认证
        if($a[0]["status"] == 1)
        {
            echo '请不要重复认证！';
        }
        else
        {
            if($token==$a[0]['token'] )
            {
                $uid=$a[0]['uid'];
                if($this->admin->change($uid))
                {
                    echo 'success';
                }
                else
                {
                    echo 'lose';
                }

            }
            else
                echo '验证认证失败，请联系管理员';
        }
    }


}