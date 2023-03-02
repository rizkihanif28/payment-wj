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
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
            ]
        })
    });

    // reset Form
    function resetForm() {
        $("[name= 'name[]']").val("")
    }

    // create permission
    // $("#store").on('submit', function(e) {
    //     e.preventDefault()
    //     $.ajax({
    //         type: "POST",
    //         url: "{{ route('permission.store') }}"
    //     })
    // })
</script>
