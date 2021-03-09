<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="flash-data" data-flashdata="<?= $this->session->flashdata("message") ?>"></div>

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <?= $this->session->flashdata('error'); ?>

  <!-- QUERY JOIN ROLE dan sesi user -->
  <?php
  $role_id = $this->session->userdata('role_id');
  $queryUser = "SELECT `user_role`.`id`, `role`
                    FROM `user_role` JOIN `user`
                    ON `user_role`.`id` = `user`.`role_id`
                    WHERE `user`.`role_id` = $role_id
                    ";
  $userRole = $this->db->query($queryUser)->result_array();
  ?>
  <?php foreach ($userRole as $ur) ?>
  <div class="card mb-3" style="max-width: 540px;">
    <div class="row no-gutter pl-3">
      <div class="col-md-4 my-3">
        <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="" class="card-img">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title"><?= $user['name']; ?></h5>
          <p class="card-text"><?= $user['email']; ?></p>
          <p class="card-text"><small class="text-muted">
              <b><?= $ur['role']; ?></b><br> since <?= date('d F Y', $user['date_created']); ?>
            </small></p>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->