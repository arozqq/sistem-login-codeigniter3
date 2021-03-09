// ajax load
$(document).ready(function (e) {
  $('form').submit('click', function (e) {
    var data = $('input').val();

    $.ajax({
      url: $(this).attr('action'),
      type: 'post',
      data: {
        "data": data
      },
      beforeSend: function () {
        $(this).attr('disabled', 'disabled');
        $('button[type=submit]').html('<i class="spinner-grow spinner-grow-sm mr-1" role="status"></i><i class="spinner-grow spinner-grow-sm mr-1" role="status"></i><i class="spinner-grow spinner-grow-sm mr-1" role="status"></i>').setTimeout(function () { }), 5000;
      },
      complete: function () {
        $('button[type=submit]').removeAttr('disabled');
        $('button[type=submit]').html('Login');
      }
    })
  });
});



// manipulasi input edit data user profile
$('.custom-file-input').on('change', function () {
  let fileName = $(this).val().split('\\').pop(); //ambil nama file
  $(this).next('.custom-file-label').addClass("selected").html(fileName); //simpan nama ke file inputnya
});
// preview upload gambar
var loadFile = function (event) {
  var output = document.getElementById('preview');
  output.src = URL.createObjectURL(event.target.files[0]);
};



// sweetalert
const flashData = $('.flash-data').data('flashdata');

if (flashData) {
  Swal.fire({
    position: 'top-center',
    icon: 'success',
    title: flashData,
    showConfirmButton: false,
    timer: 3000
  });
}


// button delete
$('.  button-delete').on('click', function (event) {
  event.preventDefault(); //matiin aksi defaultnya ketika di click
  const href = $(this).attr('href'); //ambil attribut pada tombol href yg diklik

  Swal.fire({
    title: 'Are you sure?',
    text: "This data will be delete?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      // Swal.fire(
      //   'Deleted!',
      //   'Your file has been deleted.',
      //   'success'
      // )

      // arahkan ke href yang dituju pada tombol yg bersangkutan
      document.location.href = href;

    }
  });
});


// ajax tambah dan delete role_access
$('.form-check-input').on('click', function () {
  const menuId = $(this).data('menu');
  const roleId = $(this).data('role');

  $.ajax({
    url: "http://localhost/sistem-login-lengkap/admin/changeaccess",
    type: 'post',
    data: {
      menuId: menuId,
      roleId: roleId
    },
    beforeSend: function () {
      $("#loader").show();
    },
    success: function () {
      document.location.href = "http://localhost/sistem-login-lengkap/admin/roleaccess/" + roleId;
    },
    complete: function () {
      $("#loader").hide(s);
    }
  });
});


