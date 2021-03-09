<div class="container mt-3">

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
                  <h1 class="h4 text-gray-900 mb-4">Login Page</h1>
                  <?= $this->session->flashdata('error'); ?>

                </div>

                <form class="user form-login" action="<?= base_url('auth'); ?>" method="post">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="email" placeholder="Enter Email Address..." name="email" value="<?= set_value('email'); ?>">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <button type="submit" class="btn btn-warning btn-user btn-block btn-login">
                    <i class=""></i> Login
                  </button>
                  <hr>

                </form>
                <hr>
                <div class="text-center">
                  <a class="small" id="btn-forgot" href="<?= base_url('auth/forgotpassword'); ?>">Forgot Password?</a>
                </div>
                <div class="text-center">
                  <a class="small" href="<?= base_url('auth/registration')  ?>">Create an Account!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>