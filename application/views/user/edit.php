<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- loader -->
  <div class="loader" id="loader" style="display: none;">
    <span class="loader-spinner mb-3 "></span>
    <h5 class="animate-kedip">Please Wait...</h5>
  </div>
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


  <div class="row">
    <div class="col-lg-8">

      <!-- <?= form_open_multipart('user/edit');  ?> -->
      <form action="<?= base_url('user/edit') ?>" method="post" enctype="multipart/form-data">

        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="text" class="form-control " id="email" name="email" readonly value="<?= $user['email']; ?>">
          </div>
        </div>

        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Fulname</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
            <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
          </div>
        </div>

        <div class=" form-group row">
          <div class="col-sm-2">Picture</div>
          <div class="col-sm-10">
            <div class="row">
              <div class="col-sm-3">
                <img id="preview" src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="" class="img-thumbnail">
              </div>
              <div class="col-sm-9">
                <div class="custom-file">
                  <input type="file" accept="image/*" onchange="loadFile(event)" class="custom-file-input" id="image" name="image">
                  <label class="custom-file-label" for="image">Choose file</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group row justify-content-end">
          <div class=" col-sm-10">
            <button type="submit" class="btn btn-primary">Edit</button>
          </div>
        </div>
      </form>

    </div>
  </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->