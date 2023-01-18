<script type="text/javascript">
    $(function() {

        var table = $("#dataTable2").DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
            ajax: "{{ route('siswa') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'nama_siswa',
                    name: 'nama_siswa'
                },
                {
                    data: 'nisn',
                    name: 'nisn'
                },
                {
                    data: 'kelas.nama_kelas',
                    name: 'kelas.nama_kelas'
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin'
                },
                {
                    data: 'telepon',
                    name: 'telepon'
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
        $("[name='nama_siswa']").val("")
        $("[name='username']").val("")
        $("[name='nisn']").val("")
        $("[name='nis']").val("")
        $("[name='email']").val("")
        $("[name='alamat']").val("")
        $("[name='telepon']").val("")

    }

    // create siswa
    $('#store').on('submit', function(e) {
        e.preventDefault()
        $.ajax({
            type: "POST",
            url: "{{ route('siswa.store') }}",
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
        $each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>')
        });
    }

    // edit siswa
    $("body").on("click", ".btn-edit", function() {
        var id = $(this).attr("id");
        $.ajax({
            url: "/admin/siswa/" + id + "/edit",
            type: "GET",
            success: function(response) {
                $("#id_edit").val(response.data.id);
                $("#nama_siswa_edit").val(response.data.nama_siswa);
                $("#nisn_edit").val(response.data.nisn);
                $("#nis_edit").val(response.data.nis);
                $("#jenis_kelamin_edit").val(response.data.jenis_kelamin);
                $("#email_edit").val(response.data.email);
                $("#alamat_edit").val(response.data.alamat);
                $("#telepon_edit").val(response.data.telepon);
                $("#kelas_id_edit").val(response.data.kelas_id);
                $("#editModal").modal("show");

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
        });
    });

    // action update
    $('#update').on('submit', function(e) {
        e.preventDefault()
        var id = $("#id_edit").val()
        $.ajax({
            url: '/admin/siswa/' + id,
            type: 'POST',
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
                        title: 'Uups...',
                        text: 'Not Allowed!'
                    })
                }
            }
        })
    })

    //Initialize Select2 Elements
    $('.select2').select2()
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
