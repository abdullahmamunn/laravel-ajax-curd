<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Laravel & Ajax CRUD Application!</title>
    <style>
        .swal2-cancel{
           margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center"> Laravel and Ajax Crud </h1>
  <div class="row">
      <div class="col-md-8">
         <div class="card">
             <div class="card-header">
                 <h2>All Teacher's informations</h2>
             </div>
             <div class="card-body">
                 <table class="table table-bordered">
                    <thead class="text-center">
                    <tr>
                        <th style="width: 20px">Sl</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>phone</th>
                        <th style="width: 120px">Action</th>
                    </tr>
                    </thead>
                     <tbody>
{{--                     <tr>--}}
{{--                         <td>1</td>--}}
{{--                         <td>1fdfgfdg</td>--}}
{{--                         <td>1fgdfgdfg</td>--}}
{{--                         <td>--}}
{{--                             <a href="" class="btn btn-primary" onclick="editData("+value.id+")">Edit</a>--}}
{{--                             <a href="" class="btn btn-danger">Delete</a>--}}
{{--                         </td>--}}
{{--                     </tr>--}}
                     </tbody>
                 </table>
             </div>
         </div>
      </div>
      <div class="col-md-4">
          <div class="card">
              <div class="card-header">
                 <span id="addTeacher">Add new Teacher</span>
                 <span id="updateTeacher">Update Teacher</span>
              </div>
              <div class="card-body">
                  <div class="form-group">
                      <label for="">Name</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                      <span class="text-danger" id="nameError"></span>
                  </div>
                  <div class="form-group">
                      <label for="">position</label>
                      <input type="text" class="form-control" name="name" id="position" placeholder="Enter Position">
                      <span class="text-danger" id="positionError"></span>
                  </div>
                  <div class="form-group">
                      <label for="">phone</label>
                      <input type="text" class="form-control" name="name" id="phone" placeholder="Enter Phone">
                      <span class="text-danger" id="phoneError"></span>
                  </div>
                  <div class="form-group">
                      <label for=""></label>
                      <input type="hidden" id="id">
                      <input type="submit" class="btn btn-primary" name="btn_add" id="addBtn" onclick="createNewTeacher()" value="Add">
                      <input type="submit" class="btn btn-success" name="btn_edit" id="editBtn" onclick="updateTeacher()" value="Update">
                  </div>

              </div>
          </div>

      </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/sweet-alert.js')}}"></script>

<script>
    $('#addTeacher').show();
    $('#updateTeacher').hide();
    $('#addBtn').show();
    $('#editBtn').hide();

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   function getAll(){
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: 'ajax/get-all/',
            success:function (response) {
                var data = '';
                $.each(response,function (key, value) {
                    data = data + "<tr>"
                        data = data + "<td>"+ (key+=1) +"</td>"
                        data = data + "<td>"+ value.name +"</td>"
                        data = data + "<td>"+ value.position +"</td>"
                        data = data + "<td>"+ value.phone +"</td>"
                        data = data + "<td style='width: 120px'>"
                        data = data + " <a href=\"javascript:void(0)\" class=\"btn btn-primary mr-2\" onclick=\"editData("+value.id+")\"><i class=\"fas fa-edit\"></i></a>"
                        data = data + "<a href=\"javascript:void(0)\" class=\"btn btn-danger\" onclick=\"deleteData("+value.id+")\"><i class=\"fas fa-trash\"></i></a>"
                        data = data + "</td>"
                    data = data + "</tr>"
                });
             $('tbody').html(data);

            }
        });
    }
    getAll();

   function clearData() {
      $('#name').val('');
      $('#position').val('');
      $('#phone').val('');

      $('#nameError').text('');
      $('#positionError').text('');
      $('#phoneError').text('');
   }

   function createNewTeacher(){
       let name = $('#name').val();
       let position = $('#position').val();
       let phone = $('#phone').val();

       $.ajax({
           type: 'POST',
           dataType: 'json',
           url: 'ajax/create-new-teacher/',
           data: {name: name, position:position, phone:phone},
           success: function (data) {
               clearData();
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
               $('#nameError').text(error.responseJSON.errors.name);
               $('#positionError').text(error.responseJSON.errors.position);
               $('#phoneError').text(error.responseJSON.errors.phone);
           }
       });
   }

   function editData(id) {
       $.ajax({
           type: 'GET',
           dataType: 'json',
           url: '/ajax/edit-teacher/' + id,
           success: function (data) {
               $('#updateTeacher').show();
               $('#editBtn').show();

               $('#addTeacher').hide();
               $('#addBtn').hide();

               $('#id').val(data.id);
               $('#name').val(data.name);
               $('#position').val(data.position);
               $('#phone').val(data.phone);
               console.log(data);
           }

       })
   }
   function updateTeacher() {
       let id = $('#id').val();
       let name = $('#name').val();
       let position = $('#position').val();
       let phone = $('#phone').val();

       $.ajax({
           type: 'POST',
           dataType: 'json',
           url: 'ajax/update-teacher/' + id,
           data:{name:name, position:position, phone:phone},
           success: function (data) {
               $('#updateTeacher').hide();
               $('#editBtn').hide();
               $('#addTeacher').show();
               $('#addBtn').show();
               clearData();
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
                   title: 'Data updated successfully!'
               });
           },
           error: function (error) {
               $('#nameError').text(error.responseJSON.errors.name);
               $('#positionError').text(error.responseJSON.errors.position);
               $('#phoneError').text(error.responseJSON.errors.phone);

           }
       });
   }

   function deleteData(id) {

       const swalWithBootstrapButtons = Swal.mixin({
           customClass: {
               confirmButton: 'btn btn-success',
               cancelButton: 'btn btn-danger'
           },
           buttonsStyling: false
       });

       swalWithBootstrapButtons.fire({
           title: 'Are you sure?',
           text: "You won't be able to revert this!",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Yes, delete it!',
           cancelButtonText: 'No, cancel!',
           reverseButtons: true
       }).then((result) => {
           if (result.isConfirmed) {
               $.ajax({
                   type: 'GET',
                   dataType: 'json',
                   url: 'ajax/delete/'+id,
                   success: function(data){
                       getAll();
                   }
               });
               swalWithBootstrapButtons.fire(
                   'Deleted!',
                   'Your data has been deleted.',
                   'success'
               )
           } else if (
               /* Read more about handling dismissals below */
               result.dismiss === Swal.DismissReason.cancel
           ) {
               swalWithBootstrapButtons.fire(
                   'Cancelled',
                   'Your data is safe :)',
                   'error'
               )
           }
       });
   }


</script>
</body>
</html>
