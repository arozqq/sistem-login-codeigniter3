<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Catalog extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // cek apakah ada sesi login dengan helpers
    cek_login();
  }

  // public function index()
  // {

  // }

  public function categories()
  {
    $data['title'] = 'Categories';
    // cari nama user berdasarkan table user yang sama dengan session yang sedang berlangsung
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();

    // query kategori
    $data['categories'] = $this->db->get('categories_menu')->result_array();

    // set rules add category
    $this->form_validation->set_rules('categories', 'Categories', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('catalog/categories', $data);
      $this->load->view('templates/footer');
    } else {
      $category = $this->input->post('categories');

      // insert
      $this->db->insert('categories_menu', ['categories' => $category]);
      $this->session->set_flashdata('message', 'New Categories added');
      redirect('catalog/categories');
    }
  }

  public function editcategories()
  {
    $data['title'] = 'Categories';
    // cari nama user berdasarkan table user yang sama dengan session yang sedang berlangsung
    $data['user'] = $this->db->get_where('user', ['email' =>
    $this->session->userdata('email')])->row_array();

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
}
