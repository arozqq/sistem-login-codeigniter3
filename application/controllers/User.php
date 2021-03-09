<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // cek apakah ada sesi login dengan helpers
    cek_login();
  }


  public function index()
  {
    $data['title'] = 'My Profile';
    // cari nama user berdasarkan table user yang sama dengan session yang sedang berlangsung
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();

    // query user_role
    $data['user_role'] = $this->db->get('user_role')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/index', $data);
    $this->load->view('templates/footer');
  }

  public function edit()
  {
    $data['title'] = 'Edit Profile';
    // cari nama user berdasarkan table user yang sama dengan session yang sedang berlangsung
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();

    // set rules edit profile user 
    $this->form_validation->set_rules('name', 'Name', 'required|trim');
    // $this->form_validation->set_rules('file', '', 'callback_file_check');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('user/edit', $data);
      $this->load->view('templates/footer');
    } else {
      $name = $this->input->post('name');
      $email = $this->input->post('email');

      // upload - ci otomatis menambah angka dibelakang format gambar jika sama

      // cek jika ada gambar profile yg diupload
      $upload_image = $_FILES['image']['name'];

      if ($upload_image) {
        $config['upload_path'] = './assets/img/profile';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']   = '2048';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
          // cari tau gambar lama
          $old_image = $data['user']['image'];
          // cek gambar lama bukan gambar default hapus
          if ($old_image != 'default.png') {
            unlink(FCPATH . 'assets/img/profile/' . $old_image);
          }
          // ambil nama gambar baru
          $new_image = $this->upload->data('file_name');
          // kalo ada gambar baru update juga ke table di database
          $this->db->set('image', $new_image);
        } else {
          $this->session->set_flashdata('error',  $this->upload->display_errors('<div class="alert alert-danger" style="max-width: 540px;" role="alert">', '</div>'));
          redirect('user');
        }
      }

      // query update
      $this->db->set('name', $name);
      $this->db->where('email', $email);
      $this->db->update('user');

      $this->session->set_flashdata('message', 'Data Changed!');
      redirect('user');
    }
  }


  public function changePassword()
  {
    $data['title'] = 'Change Password';
    // cari nama user berdasarkan table user yang sama dengan session yang sedang berlangsung
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();

    // query user_role
    $data['user_role'] = $this->db->get('user_role')->result_array();

    // SET RULES CHANGE PASSWORD
    $this->form_validation->set_rules('current-password', 'Current Password', 'required|trim');
    $this->form_validation->set_rules('new-password1', 'New Password', 'required|trim|min_length[3]|matches[new-password2]');
    $this->form_validation->set_rules('new-password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new-password1]');

    if ($this->form_validation->run() ==  false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('user/change-password', $data);
      $this->load->view('templates/footer');
    } else {
      $current_password =  $this->input->post('current-password');
      $new_password = $this->input->post('new-password1');
      // cek current-password sama gak kaya password di db
      if (!password_verify($current_password, $data['user']['password'])) {
        $this->session->set_flashdata('error', '<div class="alert alert-danger" style="max-width: 540px;" role="alert"> Wrong Current Password!</div>');
        redirect('user/changepassword');
      } else {
        // kalo password bener cek dulu sama ga sama current-password
        if ($current_password == $new_password) {
          $this->session->set_flashdata('error', '<div class="alert alert-danger" style="max-width: 540px;" role="alert"> New password cannot be the same as current!</div>');
          redirect('user/changepassword');
        } else {
          // kalo password baru beda sama password lama lolos ganti password nya
          $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

          $this->db->set('password', $password_hash);
          $this->db->where('email', $this->session->userdata('email'));
          $this->db->update('user');

          $this->session->set_flashdata('message', 'Password Changed!');
          redirect('user/changepassword');
        }
      }
    }
  }
}
