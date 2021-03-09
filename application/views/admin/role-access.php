<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- loader -->
  <div class="loader" id="loader" style="display: none;">
    <span class="loader-spinner mb-3 "></span>
    <h5 class="animate-kedip">Please Wait...</h5>
  </div>
  <!-- buat manggil flash data dan kirim data buat dipanggil sweetalert nya pake jquery -->
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata("message") ?>"></div>
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


  <div class="row">
    <div class="col-lg-6">

      <h5>Role : <?= $role['role']; ?></h5>

      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Menu</th>
            <th scope="col">Access</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($menu as $m) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= $m['menu']; ?></td>
              <td>
                <div class="form-check">
                  <!-- cek akses nya pake helpers -->
                  <!-- dan data- untuk proses ajax  -->
                  <input class="form-check-input" type="checkbox" <?= cek_akses($role['id'], $m['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>">
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>


</div>
<!-- /.container-fluid -->

</div>