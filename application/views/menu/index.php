<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- buat manggil flash data dan kirim data buat dipanggil sweetalert nya pake jquery -->
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata("message") ?>"></div>

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


  <div class="row">
    <div class="col-lg-6">
      <!-- ini form_error = flashdata buat error nya -->
      <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); ?>

      <a href="" class="btn btn-primary mb-3 addNewMenu" data-toggle="modal" data-target="#newMenuModal">Add New Menu</a>

      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Menu</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($menu as $m) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= $m['menu']; ?></td>
              <td>
                <a href="<?= base_url('menu/edit/'); ?><?= $m['id']; ?>" class="badge badge-warning" data-toggle="modal" data-target="#modalEdit<?= $m['id']; ?>" data-id="<?= $m['id']; ?>">Edit</a>

                <a class="badge badge-danger button-delete" href="<?= base_url('menu/delete/') . $m['id'] ?>">Delete</a>
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

<!-- add New Menu Modal -->
<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('menu'); ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu name" value="<?= set_value('menu'); ?>">
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

<!-- Modal Edit -->
<?php foreach ($menu as $m) : ?>
  <!-- Modal -->
  <div class="modal fade" id="modalEdit<?= $m['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditLabel">Edit Menu</h5>
          <form action="<?= base_url('menu/edit'); ?>" method="post">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?= $m['id']; ?>">
          <div class="form-group">
            <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu name" value="<?= $m['menu']; ?>">
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