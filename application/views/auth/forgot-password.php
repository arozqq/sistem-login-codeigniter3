<div class="container mt-3">
  <!-- loader -->
  <div class="loader" id="loader" style="display: none;">
    <span class="loader-spinner mb-3 "></span>
    <h5 class="animate-kedip">Please Wait...</h5>
  </div>
  <!-- buat manggil flash data dan kirim data buat dipanggil sweetalert nya pake jquery -->
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata("message") ?>"></div>

  <!-- Outer Row -->
  <div class="row justify-content-center">
    <div class="col-lg-7">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Forgot your password?</h1>
                  <?= $this->session->flashdata('error'); ?>

                </div>

                <form class="user form-login" action="<?= base_url('auth/forgotpassword'); ?>" method="post">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="email" placeholder="Enter Email Address..." name="email" value="<?= set_value('email'); ?>">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>

                  <button type="submit" class="btn btn-warning btn-user btn-block btn-login">
                    <i class=""></i> Reset Password
                  </button>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('auth')  ?>">Back to login</a>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>