<script>
    $(function() {
        const table = $('#dataTable2').DataTable({
            processing: true,
            serveSide: true,
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

    // Initialize Select2 Elements
    $('.select2').select2()

    // Initialize Select2 Elements
    $('.selectbs4').select2({
        theme: 'bootstrap4'
    })
</script>
