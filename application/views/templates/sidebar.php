<!-- Sidebar -->
<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion fade show" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>">
    <div class="sidebar-brand-icon">
      <i class="fas fa-store"></i>
    </div>
    <div class="sidebar-brand-text mx-3">aroz store</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider">


  <!-- QUERY MENU = ambil dari db  table menu yg boleh diakses oleh user yg bersangkkutan  -->
  <!-- join table user_menu dan user_access_menu dan where(kondisinya) ambil role id dari session sebagai fk dari user_access_menu kemudian urutkan menu_id -->
  <?php
  $role_id = $this->session->userdata('role_id');
  $queryMenu = "SELECT `user_menu`.`id`, `menu`
                  FROM `user_menu` JOIN `user_access_menu`
                    ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                 WHERE `user_access_menu`.`role_id` = $role_id
              ORDER BY `user_access_menu`.`menu_id` ASC
                ";
  $menu = $this->db->query($queryMenu)->result_array();
  ?>

  <!-- Looping menu hasil query join -->
  <!-- Nav Item - Pages Collapse Menu -->


  <?php foreach ($menu as $m) : ?>
    <!-- Heading -->
    <div class="sidebar-heading pt-2 ">
      <?= $m['menu']; ?>
    </div>

    <!-- SIAPKAN SUBMENU SESUAI MENU -->
    <!-- Join table user_sub_menu dan user_menu -->
    <!-- cek juga apakah submenu nya aktif atau engga -->
    <?php
    $menuId = $m['id'];
    $querySubMenu = "SELECT *
                      FROM `user_sub_menu` JOIN `user_menu` 
                        ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                    WHERE `user_sub_menu`.`menu_id` = $menuId
                    AND `user_sub_menu`.`is_active` = 1
                    ";
    $subMenu = $this->db->query($querySubMenu)->result_array();
    ?>

    <!-- LOOPING SUB MENU -->
    <?php foreach ($subMenu as $sm) : ?>
      <!-- Nav Item submenu -->
      <?php if ($title == $sm['title']) : ?>
        <li class="nav-item active">
        <?php else : ?>
        <li class="nav-item">
        <?php endif ?>
        <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
          <i class="<?= $sm['icon']; ?>"></i>
          <span><?= $sm['title']; ?></span></a>
        </li>
      <?php endforeach; ?>
      <!-- END LOOPING SUB MENU -->

      <!-- Divider -->
      <hr class="sidebar-divider d-md-block mt-3">

    <?php endforeach; ?>
    <!-- END LOOPING MENU -->



    <!-- Nav Item - logout -->
    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->