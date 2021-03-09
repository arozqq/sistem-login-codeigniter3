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
      <!-- ini form_error = flashdata buat error nya -->
      <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); ?>

      <a href="" class="btn btn-primary mb-3 addNewRole" data-toggle="modal" data-target="#newRoleModal">Add New Menu</a>

      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Role</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($role as $r) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= $r['role']; ?></td>
              <td>
                <a href="<?= base_url('admin/roleaccess/'); ?><?= $r['id']; ?>" class="badge badge-success">Access</a>

                <a href="<?= base_url('admin/editrole/'); ?><?= $r['id']; ?>" class="badge badge-warning" data-toggle="modal" data-target="#modalRoleEdit<?= $r['id']; ?>" data-id="<?= $r['id']; ?>">Edit</a>

                <a class="badge badge-danger button-delete" href="<?= base_url('admin/deleterole/') . $r['id'] ?>">Delete</a>
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
<!-- End of Main Content -->

<!-- add New Role Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('admin/role'); ?>" method="post">
          <div class="form-group">
            <input type="text" class="form-control" id="role" name="role" placeholder="Role name" value="<?= set_value('role'); ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>




</div>

<!-- Modal Role Edit -->
<?php foreach ($role as $r) : ?>
  <div class="modal fade" id="modalRoleEdit<?= $r['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalRoleEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalRoleEditLabel">Edit role</h5>
          <form action="<?= base_url('admin/editrole'); ?>" method="post">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?= $r['id']; ?>">
          <div class="form-group">
            <input type="text" class="form-control" id="role" name="role" placeholder="Role name" value="<?= $r['role']; ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>