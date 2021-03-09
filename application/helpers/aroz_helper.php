<!-- tambahkan nama helper di autoload helper -->
<!-- ga bisa pake $this gitu aja -->
<?php

function cek_login()
{
  // instansiasi ci untuk memanggil library ci 
  $ci = get_instance();
  // cek jika tidak sesi login redirect kembali ke auth
  if (!$ci->session->userdata('email')) {
    redirect('auth');
  } else {
    // kalo uda login
    // cek role id nya berapa
    $role_id =  $ci->session->userdata('role_id');
    // cek lagi ada di menu mana atau controller mana
    $menu = $ci->uri->segment(1);

    // query table menu berdasarkan menu yang sedang diakses untuk mendapatkan menu_id
    $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array(); //satu baris
    $menu_id = $queryMenu['id'];

    // cek apakah menu ada ga ditable user_access_menu
    // query user_access_menu
    $userAcsesss = $ci->db->get_where('user_access_menu', [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ]);

    // cek hak akses untuk membatasi akses agar safety
    if ($userAcsesss->num_rows() < 1) {
      redirect('auth/blocked');
    }
  }
}


function cek_akses($role_id, $menu_id)
{
  $ci = get_instance();

  // cari data ke tb user_access_menu yg role_id nya berapa dan menu_id nya berapa, ada gak?

  $result = $ci->db->get_where('user_access_menu', [
    'role_id' => $role_id,
    'menu_id' => $menu_id
  ]);

  // cek akses
  if ($result->num_rows() > 0) {
    return 'checked="checked"';
  }
}
