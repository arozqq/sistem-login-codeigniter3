<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    // cek apakah ada sesi login dengan helpers
    cek_login();
  }


  public function index()
  {
    $data['title'] = 'Dashboard';
    // cari nama user berdasarkan table user yang sama dengan session yang sedang berlangsung
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('templates/footer');
  }

  public function role()
  {
    $data['title'] = 'Role Management';
    // cari nama user berdasarkan table user yang sama dengan session yang sedang berlangsung
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();

    // query table user_role
    $data['role'] = $this->db->get('user_role')->result_array();

    // SET RULES UNTUK ADD ROLE
    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/role', $data);
      $this->load->view('templates/footer');
    } else {
      $data = [
        'role' => $this->input->post('role')
      ];

      // insert data role ke db
      $this->db->insert('user_role', $data);
      $this->session->set_flashdata('message', 'New Role Added!');
      // redirect to form login again
      redirect('admin/role');
    }
  }


  public function deleteRole($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_role');
    $this->session->set_flashdata('message', 'Data has been Deleted!');
    redirect('admin/role');
  }

  public function editRole()
  {
    // SET RULES UNTUK UBAH DATA SUBMENU
    $this->form_validation->set_rules('id', 'Id', 'Required');
    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == FALSE) {
      redirect('admin/role');
    } else {
      $data = [
        'role' => $this->input->post('role', true),
      ];

      $this->db->where('id', $this->input->post('id'));
      $this->db->update('user_role', $data);
      $this->session->set_flashdata('message', 'Data has been Updated!');
      redirect('admin/role');
    }
  }


  public function roleAccess($id)
  {
    $data['title'] = 'Role Access';
    // cari nama user berdasarkan table user yang sama dengan session yang sedang berlangsung
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();

    // query table user_role dan ambil role id
    $data['role'] = $this->db->get_where('user_role', ['id' => $id])->row_array();

    // jangan tampilkan semua user_menu, menu admin di hidden agar aman
    $this->db->where('id !=', 1);
    // query table user_menu
    $data['menu'] = $this->db->get('user_menu')->result_array();

    // SET RULES UNTUK ADD ROLE ACCESS
    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/role-access', $data);
      $this->load->view('templates/footer');
    } else {
      $data = [
        'role' => $this->input->post('role')
      ];

      // insert data role ke db
      $this->db->insert('user_role', $data);
      $this->session->set_flashdata('message', 'New Role Added!');
      // redirect to form login again
      redirect('admin/role');
    }
  }


  public function changeAccess()
  {
    $menu_id = $this->input->post('menuId');
    $role_id = $this->input->post('roleId');

    $data = [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ];

    // query untuk cek akses apakah ada role_id dan menu_id di dalam table

    $result = $this->db->get_where('user_access_menu', $data);

    // cek
    if ($result->num_rows() < 1) {
      // kalo ga ada insert
      $this->db->insert('user_access_menu', $data);
    } else {
      // kalo ada hapus
      $this->db->delete('user_access_menu', $data);
    }
    $this->session->set_flashdata('message', 'Access Changed!');
  }
}
