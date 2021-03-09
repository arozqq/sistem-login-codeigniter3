<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Google_login_model extends CI_Model
{
  function Is_already_register($id)
  {
    $this->db->where('login_oauth_id', $id);
    $query = $this->db->get('user_google_login');

    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  function Updata_user_data($data, $id)
  {
    $this->db->where('login_oauth_id', $id);
    $this->db->update('user_google_login', $data);
  }

  function Insert_usert_data($data)
  {
    $this->db->insert('user_google_login', $data);
  }
}
