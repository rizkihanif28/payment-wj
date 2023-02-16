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
    });

    // reset form
    // function resetForm() {
    //     $("[name='nip']").val("")
    //     $("[name='nama_petugas']").val("")
    //     $("[name='jenis_kelamin']").val("")
    // }

    // create petugas
</script>
