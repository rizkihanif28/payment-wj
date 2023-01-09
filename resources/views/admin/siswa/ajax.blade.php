<script>
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

    });
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
