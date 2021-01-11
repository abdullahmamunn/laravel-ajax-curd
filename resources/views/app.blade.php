<script>
    var adminUrl = '';
    var _modal = $('#modal');
    var btnSave = $('.btnSave');
    var btnUpdate = $('.btnUpdate');
    $.ajaxSetup({
        headers: {'X-CSRF-Token': ''}
    });
    function getRecords() {
        $.get(adminUrl + '/contacts/data')
            .success(function (data) {
                var html='';
                data.forEach(function(row){
                    html += '<tr>'
                    html += '<td>' + row.id + '</td>'
                    html += '<td>' + row.name + '</td>'
                    html += '<td>' + row.email + '</td>'
                    html += '<td>' + row.phone + '</td>'
                    html += '<td>'
                    html += '<button type="button" class="btn btn-xs btn-warning btnEdit" title="Edit Record" >Edit</button>'
                    html += '<button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' + row.id + '" title="Delete Record">Delete</button>'
                    html += '</td> </tr>';
                })
                $('table tbody').html(html)
            })
    }
    getRecords()
    function reset() {
        _modal.find('input').each(function () {
            $(this).val(null)
        })
    }
    function getInputs() {
        var id = $('input[name="id"]').val()
        var name = $('input[name="name"]').val()
        var email = $('input[name="email"]').val()
        var phone = $('input[name="phone"]').val()
        return {id: id, name: name, email: email, phone: phone}
    }
    function create() {
        _modal.find('.modal-title').text('New Contact');
        reset();
        _modal.modal('show')
        btnSave.show()
        btnUpdate.hide()
    }
    function store(){
        if(!confirm('Are you sure?')) return;
        $.ajax({
            method: 'POST',
            url: adminUrl + '/contacts/store',
            data: getInputs(),
            dataType: 'JSON',
            success: function () {
                console.log('inserted')
                reset()
                _modal.modal('hide')
                getRecords();
            }
        })
    }
    $('table').on('click', '.btnEdit', function () {
        _modal.find('.modal-title').text('Edit Contact')
        _modal.modal('show')
        btnSave.hide()
        btnUpdate.show()
        var id = $(this).parent().parent().find('td').eq(0).text()
        var name = $(this).parent().parent().find('td').eq(1).text()
        var email = $(this).parent().parent().find('td').eq(2).text()
        var phone = $(this).parent().parent().find('td').eq(3).text()
        $('input[name="id"]').val(id)
        $('input[name="name"]').val(name)
        $('input[name="email"]').val(email)
        $('input[name="phone"]').val(phone)
    })
    function update(){
        if(!confirm('Are you sure?')) return;
        $.ajax({
            method: 'POST',
            url: adminUrl + '/contacts/update',
            data: getInputs(),
            dataType: 'JSON',
            success: function () {
                console.log('updated')
                reset()
                _modal.modal('hide')
                getRecords();
            }
        })
    }
    $('table').on('click', '.btnDelete', function () {
        if(!confirm('Are you sure?')) return;
        var id = $(this).data('id');
        var data={id:id}
        $.ajax({
            method: 'POST',
            url: adminUrl + '/contacts/delete',
            data:data,
            dataType: 'JSON',
            success: function () {
                console.log('deleted');
                getRecords();
            }
        })
    })
</script>
