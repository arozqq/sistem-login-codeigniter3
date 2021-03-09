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

      <a href="" class="btn btn-primary mb-3 addnewCategories" data-toggle="modal" data-target="#newCategoriesModal">Add New Categories</a>

      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Categories</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($categories as $c) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= $c['categories']; ?></td>
              <td>
                <a href="<?= base_url('catalog/editcategories/'); ?><?= $c['id']; ?>" class="badge badge-warning" data-toggle="modal" data-target="#modalEditCategories<?= $c['id']; ?>" data-id="<?= $c['id']; ?>">Edit</a>

                <a class="badge badge-danger button-delete" href="<?= base_url('catalog/deletecategories/') . $c['id'] ?>">Delete</a>
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

<!-- add New categories Modal -->
<!-- Modal -->
<div class="modal fade" id="newCategoriesModal" tabindex="-1" role="dialog" aria-labelledby="newCategoriesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newCategoriesModalLabel">Add New Categories</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('catalog/categories'); ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="categories" name="categories" placeholder="categories name" value="<?= set_value('categories'); ?>">
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
<?php foreach ($categories as $c) : ?>
  <!-- Modal -->
  <div class="modal fade" id="modalEditCategories<?= $c['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditCategoriesLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditCategoriesLabel">Edit Categories</h5>
          <form action="<?= base_url('menu/edit'); ?>" method="post">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?= $c['id']; ?>">
          <div class="form-group">
            <input type="text" class="form-control" id="categories" name="categories" placeholder="Categories name" value="<?= $c['categories']; ?>">
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