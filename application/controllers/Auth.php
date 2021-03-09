<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model('Google_login_model');
  }

  public function index()
  {
    // tambahan - cek apkaah ada sesi login kalo ada balikin ke user supaya ga balik lagi ke auth
    if ($this->session->userdata('email')) {
      redirect('user');
    }

    // set rule for login form
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    // validaton with form validation for form login
    // when validation is false redirect to form login again
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Login Page';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/login');
      $this->load->view('templates/auth_footer');
    } else {
      // when validation success (_ = method private)
      $this->_login();
    }
  }

  private function _login()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    // query to db, search user in table of user same as in database
    $user = $this->db->get_where('user', ['email' => $email])->row_array();
    echo json_encode($user);
    // if there is user in table
    if ($user) {
      // if user active
      if ($user['is_active'] == 1) {
        // check password active
        if (password_verify($password, $user['password'])) {
          $data = [
            'email' => $user['email'],
            'role_id' => $user['role_id']
          ];
          // save data into session
          $this->session->set_userdata($data);

          // cek role_id yang login untuk memberi hak akses pada menu saat login
          if ($user['role_id'] == 1) {
            redirect('admin');
          } else {;
            redirect('user');
          }
        } else {
          // if wrong password
          $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert"> Wrong Password!</div>');
          // redirect to form login again
          redirect('auth');
        }
      } else {
        // if user not active
        $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert"> This email has not been activated!</div>');
        // redirect to form login again
        redirect('auth');
      }
    } else
      // theres is not user in table
      $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert"> This email has not been registered!</div>');
    // redirect to form login again
    redirect('auth');
  }

  public function registration()
  {
    // tambahan - cek apkah ada sesi login kalo ada balikin ke user supaya ga balik lagi ke auth
    if ($this->session->userdata('email')) {
      redirect('user');
    }

    // set rules for registration form
    $this->form_validation->set_rules('name', 'Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
      'is_unique' => 'This email has already registered'
    ]);
    $this->form_validation->set_rules(
      'password1',
      'Password',
      'required|trim|min_length[3]|matches[password2]',
      [
        'matches' => 'Password dont match',
        'min_length' => 'Password too short'
      ]
    );
    $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

    // validation with form validation for form registration
    // when validation is false redirect to form registration again
    if ($this->form_validation->run() == false) {
      $data['title'] = 'User Registration';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/registration');
      $this->load->view('templates/auth_footer');
    } else {
      // when validation success
      // sorted data and make same with table user in database
      $data = [
        'name' => htmlspecialchars($this->input->post('name', true)),
        'email' => htmlspecialchars($this->input->post('email', true)),
        'image' => 'default.png',
        'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
        'role_id' => 2,
        'is_active' => 0,
        'date_created' => time()
      ];

      // prepare token data with random_bytes and translate with base_64_encode
      $token = base64_encode(random_bytes(32));
      // siapkan data yg akan dikirim ke table di db
      $user_token = [
        'email' => htmlspecialchars($this->input->post('email', true)),
        'token' => $token,
        'date_created' => time()
      ];

      // insert data to database | data must be sorted and same with db
      $this->db->insert('user', $data);
      $this->db->insert('user_token', $user_token);

      // kirim email
      $this->_sendEmail($token, 'verify');

      //make flashdata with session before redirect
      $this->session->set_flashdata('message', 'Congratulations! your account has been created. Please Activate your account!');
      // redirect url to view 'auth'
      redirect('auth');
    }
  }


  private function _sendEmail($token, $type)
  {
    // configuration email smtp
    $config = [
      'protocol'  => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_user' => 'info.sdm37@gmail.com',
      'smtp_pass' => 'fastabiqulkhoirot',
      'smtp_port' => 465, //port smtp nya google
      'mailtype'  => 'html',
      'charset'   => 'utf-8',
      'newline'  => "\r\n"
    ];

    // panggil library email ci
    $this->load->library('email', $config);
    $this->email->initialize($config);

    // siapkan email
    // cek type email nya verify atau forgot password
    if ($type == 'verify') {
      $this->email->from('info.sdm37@gmail.com', 'Support SDM 37');
      $this->email->to($this->input->post('email'));
      $this->email->subject('Account Verification');
      $this->email->message('<!DOCTYPE html>
      <html lang="en">
      
      <head>
      
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-widsth, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        
      <title></title>
      
      <style>
      .text-center {
        text-align: center;
      }
    
      a.btn {
        padding: 12px 16px;
        text-decoration: none;
        color: #000;
        border-radius: 8px;
      }
    
      .btn-primary {
        background-color: #ffff9e;
        color: #000;
      }
    
      .btn-primary:hover {
        color: rgb(167, 109, 1);
      }

      .col-lg{
        min-height:400px;
      }
      
      </style>
      </head>

      
      <body>
        <div class="row">
        <div class="col-lg text-center">
        <h3>Please Click this link to verify your account :</h3>
        <div class="form-group">
        <a class="btn btn-primary" href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>
        </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>');
    } else if ($type == 'forgot') {
      $this->email->from('info.sdm37@gmail.com', 'Support SDM 37');
      $this->email->to($this->input->post('email'));
      $this->email->subject('Reset Password');
      $this->email->message('<!DOCTYPE html>
      <html lang="en">
      
      <head>
      
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-widsth, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        
      <title></title>
      
      <style>
      .text-center {
        text-align: center;
      }
    
      a.btn {
        padding: 12px 16px;
        text-decoration: none;
        color: #000;
        border-radius: 8px;
      }
    
      .btn-primary {
        background-color: #ffff9e;
        color: #000;
      }
    
      .btn-primary:hover {
        color: rgb(167, 109, 1);
      }

      .col-lg{
        min-height:400px;
      }
      
      </style>
      </head>

      
      <body>
        <div class="row">
        <div class="col-lg text-center">
        <h3>Please Click this link to reset your password :</h3>
        <div class="form-group">
        <a class="btn btn-primary" href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>
        </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>');
    }

    // kirim email nya
    if ($this->email->send()) {
      return true;
    } else {
      echo $this->email->print_debugger();
      die;
    }
  }

  public function verify()
  {
    // ambil dari url
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    // query ke db ada ga user nya ditable
    $user = $this->db->get_where('user', ['email' => $email])->row_array();

    if ($user) {
      // 
      $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

      // cek kalo ada usernya yg sama sesuai dengan token
      if ($user_token) {
        // bikin masa waktu validasi
        if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
          // kalo bener update tb usernya
          $this->db->set('is_active', 1);
          $this->db->where('email', $email);
          $this->db->update('user');

          // dan hapus user token nya kalo udah bener
          $this->db->delete('user_token', ['email' => $email]);
          $this->session->set_flashdata('message',  $email . ' has been activated! Please Login');
          redirect('auth');
        } else {
          // kalo token lebih dari sehari akan invalid dan hapus usernya
          $this->db->delete('user', ['email' => $email]);
          $this->db->delete('user_token', ['email' => $email]);

          $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert"> Account activation failed! Token expired.</div>');
          redirect('auth');
        }
      } else {
        // kalo token salah / invalid
        $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert"> Account activation failed! Token invalid.</div>');
        redirect('auth');
      }
    } else {
      // kalo ga ada di table usernya
      $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert"> Account activation failed! Wrong email.</div>');
      redirect('auth');
    }
  }


  public function forgotPassword()
  {
    // set rules
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Forgot Password';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/forgot-password');
      $this->load->view('templates/auth_footer');
    } else {
      $email = $this->input->post('email');
      // cek ada ga email nya di dalam database dan is_active nya 1 ga ?
      $user = $this->db->get_where('user', [
        'email' => $email,
        'is_active' => 1
      ])->row_array();

      if ($user) {
        // cek kalo ada usernya bikin token
        $token = base64_encode(random_bytes(32));
        // siapkan data yg akan dikirim ke table di db
        $user_token = [
          'email' => $email,
          'token' => $token,
          'date_created' => time()
        ];

        // insert ke db
        $this->db->insert('user_token', $user_token);

        // kirim email
        $this->_sendEmail($token, 'forgot');
        $this->session->set_flashdata('message', 'Please check your email to reset your password');
        redirect('auth/forgotpassword');
      } else {
        // kalo ga ada kasih pesan kesalahan
        $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert"> Email is not registered or activated!</div>');
        redirect('auth/forgotpassword');
      }
    }
  }

  public function resetPassword()
  {
    // ambil data dari url
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    // cek ada ga data nya di db
    $user = $this->db->get_where('user', ['email' => $email])->row_array();

    // cek kalo ada
    if ($user) {
      $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
      // cek user token
      if ($user_token) {
        // ini tanpa expired token
        // kalo email nya bener dan token nya bener
        $this->session->set_userdata('reset_email', $email);
        // tampilin halaman change passw;ord
        $this->changePassword();
      } else {
        // kalo ga ada token
        $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert"> Reset password failed! Wrong token.</div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert"> Reset password failed! Wrong email.</div>');
      redirect('auth');
    }
  }

  public function changePassword()
  {
    // kalo ga ada session reset_email balikin ke auth
    if (!$this->session->userdata('reset_email')) {
      redirect('auth');
    }
    // SET RULES
    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]');
    $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|min_length[3]|matches[password1]');

    if ($this->form_validation->run() == false) {
      $data['title'] = 'Change Password';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/change-password');
      $this->load->view('templates/auth_footer');
    } else {
      $password =  password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

      $email = $this->session->userdata('reset_email');

      // hapus user_token sebelum update supaya ga numpuk
      $this->db->delete('user_token', ['email' => $email]);
      // update
      $this->db->set('password', $password);
      $this->db->where('email', $email);
      $this->db->update('user');

      // sebelum balikin ke halaman login hapus dulu session nya
      $this->session->unset_userdata('reset_email');

      $this->session->set_flashdata('message', 'Password has been changed!');
      redirect('auth');
    }
  }


  public function logout()
  {
    // clear session
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('role_id');

    $this->session->set_flashdata('message', 'You have been logout!');
    redirect('auth');
  }

  public function blocked()
  {
    $data['title'] = "Aroz Store";

    $this->load->view('templates/header', $data);
    $this->load->view('auth/blocked', $data);
  }



  // ------------GOOGLE LOGIN-------------------- //

}
