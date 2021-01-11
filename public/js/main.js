$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('#contactForm').submit(function (e) {
    e.preventDefault();
});
function clearMsg(){
     $('#name').val('');
     $('#email').val('');
     $('#phone').val('');

    $('#nameErrorMsg').text('');
    $('#emailErrorMsg').text('');
    $('#phoneErrorMsg').text('');
}

// Create new contact
function createContact(){
    let name = $('#name').val();
    let email = $('#email').val();
    let phone = $('#phone').val();

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'contacts/store/',
        data:{name: name, email: email, phone:phone},
        success: function (data) {
            clearMsg();
            getAll();
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: 'Data added successfully!'
            });

        },
        error: function (error) {
            $('#nameErrorMsg').text(error.responseJSON.errors.name);
            $('#emailErrorMsg').text(error.responseJSON.errors.email);
            $('#phoneErrorMsg').text(error.responseJSON.errors.phone);

           console.log(error);
        }
    });
}
createContact();

// get all contact

function getAll(){
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: 'get-contact/',
        success:function (response) {
            var data = '';
            $.each(response,function (key, value) {
                data = data + "<tr>"
                data = data + "<td>"+ (key+=1) +"</td>"
                data = data + "<td>"+ value.name +"</td>"
                data = data + "<td>"+ value.email +"</td>"
                data = data + "<td>"+ value.phone +"</td>"
                data = data + "<td style='width: 120px'>"
                data = data + "<a href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#editModal\" onclick=\"editData("+value.id+")\" class=\"btn btn-primary mr-2\"><i class=\"fas fa-edit\"></i></a>"
                data = data + "<a href=\"javascript:void(0)\" class=\"btn btn-danger\" onclick=\"deleteData("+value.id+")\"><i class=\"fas fa-trash\"></i></a>"
                data = data + "</td>"
                data = data + "</tr>"
            });
            $('tbody').html(data);
            console.log(data);

        }
    });
}
getAll();

function editData(id){
      $('#id').val(id);
      $.ajax({
          type: 'GET',
          dataType: 'json',
          url: 'contact/edit/' + id,
          success: function (data) {
              $('#nameEdit').val(data.name);
              $('#emailEdit').val(data.email);
              $('#phoneEdit').val(data.phone);
          }

      })

}


function updateContact(){
    let id =  $('#id').val();
    let name = $('#nameEdit').val();
    let email = $('#emailEdit').val();
    let phone = $('#phoneEdit').val();

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'contact/update/' + id,
        data:{name:name, email:email, phone:phone},
        success: function (data) {
            getAll();
            clearMsg();
        },
        error: function (error) {
            $('#nameErrorMsg').text(error.responseJSON.errors.name);
            $('#emailErrorMsg').text(error.responseJSON.errors.email);
            $('#phoneErrorMsg').text(error.responseJSON.errors.phone);
        }
    })

}


function deleteData(id) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'contact/delete/'+ id,
        success: function(data){
            getAll();
        }
    });
}









// $(document).on('click','#edit',function () {
//       let id = $(this).val(data.id);
//       console.log(id);
// });
