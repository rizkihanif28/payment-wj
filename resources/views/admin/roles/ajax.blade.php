<script type="text/javascript">
    $(function() {
        const table = $("#dataTable2").DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
            ajax: "{{ route('roles.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
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
        });
    });

    // reset form
    function resetForm() {
        $("[name= 'nama']").val("")
        $("[name= 'role']").val("")
    }

    // create role
</script>
