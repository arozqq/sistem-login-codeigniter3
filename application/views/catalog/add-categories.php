<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- loader -->
  <div class="loader" id="loader" style="display: none;">
    <span class="loader-spinner mb-3 "></span>
    <h5 class="animate-kedip">Please Wait...</h5>
  </div>
  <div class="row">
    <div class="col-sm col-md-3 col-lg-9 mt-2">
      <!-- Page Heading -->
      <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    </div>
    <div class=" col-md col-lg-3 mb-3">
      <a href="<?= base_url('catalog/addcategories'); ?>" class="btn btn-primary" title="add new"><i class="fas fa-fw fa-plus"></i></a>
      <a href="" class="btn btn-danger" title="delete"><i class="fas fa-fw fa-trash"></i></a>
    </div>
  </div>

  <div class="row">
    <div class="col-md col-lg-10">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">General</a>
          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
          <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
        </div>
      </nav>

      <form action="">
        <div class="tab-content mt-3" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 col-md-2 col-form-label">Category<sup class="text-danger">*</sup></label>
              <div class="col-sm-6">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
              </div>
            </div>

            <div class="form-group row">
              <label for="inputP" class="col-sm-3 col-md-2">Description<sup class="text-danger">*</sup></label>
              <div class="col-sm col-lg">
                <textarea class="ckeditor" id="cke_editor1"></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 col-md-2 col-form-label">Meta Tag<sup class="text-danger">*</sup></label>
              <div class="col-sm-6">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
              </div>
            </div>

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 col-md-2 col-form-label">Meta Tag Description</label>
              <div class="col-sm-6">
                <div class="form-group">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 col-md-2 col-form-label">Meta Tag Keyword</label>
              <div class="col-sm-6">
                <div class="form-group">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
              </div>
            </div>

          </div>
          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
          <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>

        </div>
      </form>

    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->