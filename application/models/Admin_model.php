<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function get_all()       
    {
        $result = $this->db->get_where('tb_adminstaff',['deleted' => 0]);
        return $result;
    }
    public function get_nonaktif()       
    {
        $result = $this->db->get_where('tb_adminstaff',['deleted' => 1]);
        return $result;
    }

    public function create($data)
    {
        $this->db->insert('tb_adminstaff', $data);
        return $this->db->affected_rows() > 0 ? true : false;
    }

    public function update($data_adminstaff, $id)
    {
        $this->db->update('tb_adminstaff', $data_adminstaff, ['id_adminstaff' => $id]);
        return $this->db->affected_rows() > 0 ? true : false;
    } 

    public function user()
     {
        $this->db->select('nama_adminstaff');
        $this->db->from('tb_adminstaff');
         $query = $this->db->get();
         return $query->row_array();
    }

     public function role()
     {
         $this->db->select('role');
         $this->db->from('tb_adminstaff');
         $query = $this->db->get();
         return $query->row_array();
     }
}
