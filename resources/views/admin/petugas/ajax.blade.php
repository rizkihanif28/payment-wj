<script>
    $(function() {
        var table = $("#dataTable2").DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
            ajax: "{{ route('petugas.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'nip',
                    name: 'nip'
                },
                {
                    data: 'nama_petugas',
                    name: 'nama_petugas'
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
            ]
        });
    })

    // reset form
    function resetForm() {
        $("[name='username']").val("")
        $("[name='nip']").val("")
        $("[name='nama_petugas']").val("")
        $("[name='jenis_kelamin']").val("")
        $("[name='email']").val("")
    }

    // create petugas
    $("#store").on('submit', function(e) {
        e.preventDefault()
        $.ajax({
            type: "POST",
            url: "{{ route('petugas.store') }}",
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

    // edit petugas
    $("body").on("click", ".btn-edit", function() {
        var id = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: "/admin/petugas/" + id + "/edit",
            success: function(response) {
                $("#id_edit").val(response.data.id)
                $("#nip_edit").val(response.data.nip)
                $("#nama_petugas_edit").val(response.data.nama_petugas)
                $("#email_edit").val(response.data.email)
                $("#jenis_kelamin_edit").val(response.data.jenis_kelamin)
                $("#editModal").modal("show")
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
        });
    });

    // action update
    $("#update").on("submit", function(e) {
        e.preventDefault()
        var id = $("#id_edit").val()
        $.ajax({
            type: "POST",
            url: "/admin/petugas/" + id + "/update",
            data: $(this).serialize(),
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    $("#editModal").modal("hide")
                    $("#dataTable2").DataTable().ajax.reload()
                    Swal.fire(
                        '',
                        response.message,
                        'success'
                    )
                } else {
                    printErrorMsg(response.error)
                }
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
        });
    });

    // action delete
    $("body").on("click", ".btn-delete", function() {
        const id = $(this).attr("id");
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
                    url: "/admin/petugas/" + id + "/delete",
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
    });

    //Initialize Select2 Elements
    $('.select2').select2()
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
