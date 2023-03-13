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
                dynamic_field(1);
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

    // edit 
    $('body').on('click', '.btn-edit', function() {
        var id = $(this).attr("id")
        $.ajax({
            url: "/admin/permission/" + id + "/edit",
            type: "GET",
            success: function(response) {
                $("#id_edit").val(response.data.id)
                $("#name_edit").val(response.data.name)
                $("#editModal").modal("show")

            }
        })
    })

    //update
    $("#update").on("submit", function(e) {
        e.preventDefault()
        var id = $("#id_edit").val()
        $.ajax({
            url: "/admin/permission/" + id + "/update",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
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

    // delete
    $("body").on("click", ".btn-delete", function() {
        var id = $(this).attr("id")

        Swal.fire({
            title: 'Yakin hapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fc544b',
            cancelButtonColor: '#78828a',
            confirmButtonText: 'Hapus',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "/admin/permission/" + id + "/delete",
                    success: function(response) {
                        $("#dataTable2").DataTable().ajax.reload()
                        Swal.fire(
                            '',
                            response.message,
                            'success'
                        )
                    },
                    error: function(err) {
                        if (err.status == 403) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Uups...',
                                text: 'Not Allowed!'
                            })
                        }
                    }
                })
            }
        })
    })

    // form tambah dinamis
    var count = 1;
    dynamic_field(count);

    function dynamic_field(number) {
        html = '<tr>';
        html += '<td><input type="text" required id="tag" name="[]" class="form-control"/></td>';
        if (number > 1) {
            html +=
                '<td><button type="button" name="remove" id="" class="btn btn-danger remove"><i class="fas fa-window-close fa-fw"></i> REMOVE</button></td></tr>';
            $('tbody').append(html);
        } else {
            html +=
                '<td><button type="button" name="add" id="add" class="btn btn-success"><i class="fas fa-plus fa-fw"></i> ADD</button></td></tr>';
            $('tbody').html(html);
        }
    }

    $(document).on('click', '#add', function() {
        count++;
        dynamic_field(count);
    });

    $(document).on('click', '.remove', function() {
        count--;
        $(this).closest("tr").remove();
    });
</script>
