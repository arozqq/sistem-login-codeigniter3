<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // cek apakah ada sesi login dengan helpers
    cek_login();
  }

  public function index()
  {
    $data['title'] = 'Menu Management';
    // cari nama user berdasarkan table user yang sama dengan session yang sedang berlangsung
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();

    // query data menu
    $data['menu'] = $this->db->get('user_menu')->result_array();

    // SET RULES UNTUK ADD MENU 
    $this->form_validation->set_rules('menu', 'Menu', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/index', $data);
      $this->load->view('templates/footer', $data);
    } else {
      // kalo berhasil tambah data baru
      $this->db->insert('user_menu', ['menu' => $this->input->post('menu', true)]);
      $this->session->set_flashdata('message', 'Data has been Added!');
      // redirect to form login again
      redirect('menu');
    }
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_menu');
    $this->session->set_flashdata('message', 'Data has been Deleted!');
    redirect('menu');
  }

  public function edit()
  {
    $this->form_validation->set_rules('id', 'Id', 'Required');
    $this->form_validation->set_rules('menu', 'Menu', 'Required');

    if ($this->form_validation->run() == FALSE) {
      redirect('menu');
    } else {
      $data = [
        'menu' => $this->input->post('menu', true)
      ];

      $this->db->where('id', $this->input->post('id'));
      $this->db->update('user_menu', $data);
      $this->session->set_flashdata('message', 'Data has been Updated!');
      redirect('menu');
    }
  }

  public function submenu()
  {
    $data['title'] = 'Submenu Management';
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();
    $this->load->model('Menu_model', 'menu');

    // query data submenu
    $data['subMenu'] = $this->menu->getSubMenu();
    $data['menu'] = $this->db->get('user_menu')->result_array();

    // SET RULES UNTUK ADD SUB MENU 
    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('url', 'URL', 'required');
    $this->form_validation->set_rules('icon', 'Icon', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/submenu', $data);
      $this->load->view('templates/footer', $data);
    } else {
      // siapkan data sebelum insert
      $data = [
        'title' => $this->input->post('title'),
        'menu_id' => $this->input->post('menu_id'),
        'url' => $this->input->post('url'),
        'icon' => $this->input->post('icon'),
        'is_active' => $this->input->post('is_active')
      ];
      // insert data submenu ke database
      $this->db->insert('user_sub_menu', $data);
      $this->session->set_flashdata('message', 'New SubMenu Added!');
      // redirect to form login again
      redirect('menu/submenu');
    }
  }

  public function deletesubmenu($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_sub_menu');
    $this->session->set_flashdata('message', 'Data has been Deleted!');
    redirect('menu/submenu');
  }

  public function editSubMenu()
  {
    // SET RULES UNTUK UBAH DATA SUBMENU
    $this->form_validation->set_rules('id', 'Id', 'Required');
    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('url', 'URL', 'required');
    $this->form_validation->set_rules('icon', 'Icon', 'required');

    if ($this->form_validation->run() == FALSE) {
      redirect('menu/submenu');
    } else {
      $data = [
        'title' => $this->input->post('title', true),
        'menu_id' => $this->input->post('menu_id', true),
        'url' => $this->input->post('url', true),
        'icon' => $this->input->post('icon', true),
        'is_active' => $this->input->post('is_active', true)
      ];

      $this->db->where('id', $this->input->post('id'));
      $this->db->update('user_sub_menu', $data);
      $this->session->set_flashdata('message', 'Data has been Updated!');
      redirect('menu/submenu');
    }
  }
}
