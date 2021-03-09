<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- loader -->
  <div class="loader" id="loader" style="display: none;">
    <span class="loader-spinner mb-3 "></span>
    <h5 class="animate-kedip">Please Wait...</h5>
  </div>
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata("message") ?>"></div>

  <!-- Page Heading -->
  <h1 class="h2 mb-4 text-gray-800"><?= $title; ?></h1>
  <?= $this->session->flashdata('error'); ?>

  <div class="row">
    <div class="col-lg-6">
      <form action="<?= base_url('user/changepassword'); ?>" method="post">
        <div class="form-group">
          <label for="current-password">Current Password</label>
          <input type="password" class="form-control" id="current-password" name="current-password">
          <?= form_error('current-password', '<small class="text-danger pl-2">', '</small>'); ?>
        </div>

        <div class="form-group">
          <label for="new-password1">New Password</label>
          <input type="password" class="form-control" id="new-password1" name="new-password1">
          <?= form_error('new-password1', '<small class="text-danger pl-2">', '</small>'); ?>
        </div>

        <div class="form-group">
          <label for="new-password2">Repeat Password</label>
          <input type="password" class="form-control" id="new-password2" name="new-password2">
          <?= form_error('new-password2', '<small class="text-danger pl-2">', '</small>'); ?>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Change Password</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->