<?php
/**
 * Created by PhpStorm.
 * User: dongdong
 * Date: 16-3-9
 * Time: 下午7:30
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{
    //注册信息入库
    public function add($data){
        $this->db->insert('staruser',$data);
    }

    /**
     * @param $data
     * @return bool
     */
    public function check_new($data, $error){
        $this->db->where('username', $data['username']);
        $this->db->from('staruser');
        if ($this->db->count_all_results() > 0)
        {
            $error[] = 'the username has been used';
        }

        $this->db->where('email', $data['email']);
        $this->db->from('staruser');
        if ($this->db->count_all_results() > 0)
        {
            $error[] = 'the email has been used';
        }

        return $error;
    }

    public function check($token){
//信息查询取出
        $data=$this->db->get_where('staruser',array('token'=>$token))->result_array();
        return $data;
    }

    public function change($uid){
        //数据更新
        $q = $this->db->simple_query('UPDATE staruser SET status =1 WHERE uid ='.$uid.';');
        return $q;
    }

}
