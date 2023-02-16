<script>
    $(function() {
        const table = $('#dataTable2').DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
            ajax: "{{ route('user.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'username',
                    name: 'username',
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
            ]
        });
    });

    // reset form
    function resetForm() {
        $("[name='username']").val("")
        $("[name='email']").val("")
        $("[name='password']").val("")

    }

    // create user
    $('#store').on('submit', function(e) {
        e.preventDefault()
        $.ajax({
            type: "POST",
            url: "{{ route('user.store') }}",
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
                    resetForm()
                } else {
                    printErrorMsg(response.error)
                }
            }
        });
    });

    // create error validation
    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>')
        });
    }

    // edit user
    $("body").on("click", ".btn-edit", function() {
        var id = $(this).attr("id")

        $.ajax({
            url: "/admin/user/" + id + "/edit",
            type: "GET",
            success: function(response) {
                $("#editModal").modal("show")
                $("#id").val(response.data.id)
                $("#username").val(response.data.username)
                $("#old_password").val(response.data.password)
                $("#email").val(response.data.email)
            }
        })
    })

    // update
    $("#update").on("submit", function(e) {
        e.preventDefault()
        var id = $("#id").val()
        $.ajax({
            url: "/admin/user/" + id + "/update",
            type: "POST",
            data: $(this).serialize(),
            success: function() {
                $("#dataTable2").DataTable().ajax.reload();
                $("#editModal").modal("hide")
                Swal.fire(
                    'Update',
                    'Berhasil update!',
                    'success'
                )
            }
        })
    })

    // delete
    $("body").on("click", ".btn-delete", function() {
        const id = $(this).attr("id");
        Swal.fire({
            title: 'Yakin hapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fc544b',
            cancelmButtonColor: '#78828a',
            confirmButtonText: 'Hapus',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/user/" + id + "/delete",
                    type: 'DELETE',
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
                                title: 'Uups ...',
                                text: 'Not Allowed!'
                            })
                        }
                    }
                })
            }
        })
    })

    // Initialize Select2 Elements
    $('.select2').select2()
    $('.selectbs4').select2({
        theme: 'bootstrap4'
    })
</script>
