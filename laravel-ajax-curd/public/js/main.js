$.ajaxSetup({
   headers:{
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});
$('#contactForm').submit(function(e){
    e.preventDefault();

    // var formData = {
    //     url: jQuery('#link').val(),
    //     description: jQuery('#description').val(),
    // };


    // let input = $('#createTaskForm input[name="name"]');
    let formData = {
        // name: $('#contactForm input[name="name"]').val(),
        // email: $('#contactForm input[name="email"]').val(),
        // phone: $('#contactForm input[name="phone"]').val(),
        name: $('#name').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
    };
    console.log(formData)
    $.ajax({
        type: 'POST',
        url : '/contacts/store',
        data: formData,
        success: function (data) {
           let msg = $('#successMsg');
           $(msg).append('<div class="alert alert-primary" role="alert">' +
               'New contact added' +
               '</div>');
            $('#contactForm').trigger("reset");
            $('#contactTable').prepend('' +
                '<tr>\n' +
                '                <td>'+  +'</td>\n' +
                '                <td>'+data.name+'</td>\n' +
                '                <td>'+data.email+'</td>\n' +
                '                <td>'+data.phone+'</td>\n' +
                '                <td style="width:150px">\n' +
                '                    <a href="#" data-toggle="modal" data-target="#editTask" class="btn btn-sm btn-primary edit">Edit</a>\n' +
                '                    <a href="#" data-toggle="modal" data-target="#deleteTask"  class="btn btn-sm btn-danger delete">Delete</a>\n' +
                '                </td>\n' +
                '            </tr>');

        },
        error: function (data) {
          console.log('Error:', data)
        }
    })
});

$(document).on('click','#edit',function () {
      let id = $(this).val(data.id);
      console.log(id);
});
