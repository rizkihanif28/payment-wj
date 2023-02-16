<script type="text/javascript">
    $(function() {
        var table = $("#dataTable2").DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
            ajax: "{{ route('kelas.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'nama_kelas',
                    name: 'nama_kelas',
                },
                {
                    data: 'kompetensi_keahlian',
                    name: 'kompetensi_keahlian'
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
        $("[name= 'nama_kelas']").val("")
        $("[name= 'kompetensi_keahlian']").val("")
    }

    // create kelas
    $("#store").on('submit', function(e) {
        e.preventDefault()
        $.ajax({
            type: "POST",
            url: "{{ route('kelas.store') }}",
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

    // edit kelas
    $("body").on("click", ".btn-edit", function() {
        var id = $(this).attr("id");
        $.ajax({
            url: "/admin/kelas/" + id + "/edit",
            type: "GET",
            success: function(response) {
                $("#id_edit").val(response.data.id)
                $("#nama_kelas_edit").val(response.data.nama_kelas)
                $("#kompetensi_keahlian_edit").val(response.data.kompetensi_keahlian)
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
            url: "/admin/kelas/" + id + "/update",
            type: "POST",
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
        var id = $(this).attr("id");
        Swal.fire({
            title: 'Yakin hapus data ini?',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#fc544b',
            cancelButtonColor: '#78828a',
            confirmButtonText: 'Hapus',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/kelas/" + id + "/delete",
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
    });
</script>
