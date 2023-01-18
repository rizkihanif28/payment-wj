<script type="text/javascript">
    $(function() {
        var table = $("#dataTable2").dataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('kelas') }}",
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
    })
</script>
