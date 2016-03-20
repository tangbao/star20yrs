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
         $index = $this->captcha();
         $this->load->view('register.html', $index);
    }

    public function captcha(){
        $this->load->helper('captcha');//载入验证码函数
        /*
        * 配置项
         */
        $speed = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $word = '';
        for ($i = 0; $i < 4; $i++) {
            $word .= $speed[mt_rand(0, strlen($speed) - 1)];

        }
        //参数，注意要创建文件夹保存验证码图片，字体随便换吧
        $vals = array(
            'word'      => $word,
            'img_path'  => './captcha/',
            'img_url'   => 'http://localhost:5555/captcha',
            'font_path' => './path/to/fonts/texb.ttf',
            'img_width' => '50',
            'img_height'    => '30',
            'expiration'    => '180',
            'word_length'   => '100',
            'font_size' => '100',
            'img_id'    => 'Imageid',
            'pool'      => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',


            'colors'    => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            )
        );

        $cap = create_captcha($vals);
        //验证码值写入SESSION，载入视图
        if(!isset($_SESSION)){session_start();}

        $_SESSION['dong'] = sha1($cap['word'].'dongdong_captcha');
        $index['captcha'] = $cap['image'];
        //echo $index['captcha'];
        return $index;
    }

    //获取提交的信息
    public function add(){
        $this->load->model('Admin_model', 'admin');
        $this->load->library('email');
        $error[] = array();

        //xss clean and verify whether the data is valid
        $captcha = $this->security->xss_clean($this->input->post('captcha'));
        if (sha1($captcha.'dongdong_captcha') != $_SESSION['dong'])
        {
            $error[] = "请输入正确的验证码";
        }

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
            'token' => $token
        );

        $error = $this->admin->check_new($data, $error);

        //when count($error) > 1 , there must be error(s).
        if (count($error) > 1)
        {
            echo 'error:';
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