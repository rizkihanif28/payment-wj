<script type="text/javascript">
    $(function() {
        const table = $("#dataTable2").DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
            ajax: "{{ route('permission.index') }}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'id'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: true
            }, ]
        });
    });

    // reset Form
    function resetForm() {
        $("[name= 'name[]']").val("")
    }

    // create permission
    $("#store").on('submit', function(e) {
        e.preventDefault()
        $.ajax({
            type: "POST",
            url: "{{ route('permission.store') }}",
            data: $(this).serialize(),
            success: function(response) {
                resetForm()
                if ($.isEmptyObject(response.error)) {
                    $("#createModal").modal("hide")
                    $("#dataTable2").DataTable().ajax.reload()
                    Swal.fire(
                        '',
                        response.message,
                        'success'
                    )
                } else {
                    printErrorMsg(response.error)
                }
            }
        })
    })

    // create error validation
    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>')
        });
    }
</script>
