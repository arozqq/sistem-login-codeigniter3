<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- buat manggil flash data dan kirim data buat dipanggil sweetalert nya pake jquery -->
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata("message") ?>"></div>

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


  <div class="row">
    <div class="col-lg-6">
      <!-- ini form_error = flashdata buat error nya -->
      <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?= validation_errors(); ?>
        </div>
      <?php endif; ?>


      <a href="" class="btn btn-primary mb-3 addNewMenu" data-toggle="modal" data-target="#newSubMenuModal">Add New Submenu</a>

      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Menu</th>
            <th scope="col">Url</th>
            <th scope="col">Icon</th>
            <th scope="col">Active</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($subMenu as $sm) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= $sm['title']; ?></td>
              <td><?= $sm['menu']; ?></td>
              <td><?= $sm['url']; ?></td>
              <td><?= $sm['icon']; ?></td>
              <td><?= $sm['is_active']; ?></td>
              <td>
                <a class="badge badge-warning" href="<?= base_url('menu/editsubmenu/') . $sm['id']; ?>" data-toggle="modal" data-target="#modal-edit-subMenu<?= $sm['id']; ?>" data-id="<?= $sm['id']; ?>"">Edit</a>

                <a class=" badge badge-danger button-delete" href="<?= base_url('menu/deletesubmenu/') . $sm['id'] ?>">Delete</a>
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

<!-- add New SubMenu Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newSubMenuModalLabel">Add New Submenu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('menu/submenu'); ?>" method="post">
          <div class="form-group">
            <input type="text" class="form-control" id="title" name="title" placeholder="Submenu name">
          </div>
          <div class="form-group">
            <select name="menu_id" id="menu_id" class="form-control">
              <option value="">Select Menu</option>
              <?php foreach ($menu as $m) : ?>
                <option value="<?= $m['id']  ?>"><?= $m['menu']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
          </div>
          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1" checked>
              <label for="is_active" class="form-check-label">
                Active ?
              </label>
            </div>
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

<!-- Modal edit data submenu-->
<?php foreach ($subMenu as $sm) : ?>
  <div class="modal fade" id="modal-edit-subMenu<?= $sm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form action="<?= base_url('menu/editsubmenu'); ?>" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="formModalLabel">Edit Data SubMenu </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <input type="hidden" name="id" value="<?= $sm['id']; ?>">

            <div class="form-group">
              <input type="text" class="form-control" id="title" name="title" placeholder="Nama Sub Menu" value="<?= $sm['title']; ?>">
            </div>

            <div class="form-group">
              <select name="menu_id" id="menu_id" class="form-control">
                <option value="">Choose menu</option>
                <?php foreach ($menu as $m) : ?>
                  <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" id="url" name="url" placeholder="url" value="<?= $sm['url']; ?>">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" id="icon" name="icon" placeholder="icon" value="<?= $sm['icon']; ?>">
            </div>

            <div class="form-group">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1" checked>
                <label for="is_active" class="form-check-label">
                  Active?
                </label>
              </div>
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="submit" class="btn btn-primary">Edit</button>
        </form>
      </div>
    </div>
  </div>
  </div>
<?php endforeach; ?>