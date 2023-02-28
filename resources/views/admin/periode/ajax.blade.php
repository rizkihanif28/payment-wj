<script type="text/javascript">
    $(function() {
        const table = $("#dataTable2").DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
            ajax: "{{ route('periode.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'tahun',
                    name: 'tahun',
                },
                {
                    data: 'nominal',
                    name: 'nominal'
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

    // reset Form
    function resetForm() {
        $("[name= 'tahun']").val("")
        $("[name= 'nominal']").val("")
    }

    // create periode
    $("#store").on("submit", function(e) {
        e.preventDefault()
        $.ajax({
            type: "POST",
            url: "{{ route('periode.store') }}",
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

    // edit periode
    $("body").on("click", ".btn-edit", function() {
        const id = $(this).attr("id");
        $.ajax({
            url: "/admin/periode/" + id + "/edit",
            type: "GET",
            success: function(response) {
                $("#id_edit").val(response.data.id)
                $("#tahun_edit").val(response.data.tahun)
                $("#nominal_edit").val(response.data.nominal)
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
        })
    })

    // action update 
    $("#update").on("submit", function(e) {
        e.preventDefault()
        const id = $("#id_edit").val()
        $.ajax({
            url: "/admin/periode/" + id + "/update",
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
        })
    })

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
                    url: "/admin/periode/" + id + "/delete",
                    type: "DELETE",
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
</script>
