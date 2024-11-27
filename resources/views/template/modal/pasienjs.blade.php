
<script>
  $(function () {
    let pasien_name;
  const table_pasien = $("#data-pasien").DataTable({
      searching: true,
      ajax: '{{ url("get/data/pasien") }}',
      columns: [
        {
          data: "DT_RowIndex",
          name: "DT_RowIndex",
          className: "text-center",
        },
        {
            name: "Name",
            data: "name",
            className: "text-center",
            sortable: true,
            render: function (data) {
              pasien_name = data;
              return data;
            }
        },
        {
            name: "Gender",
            data: "gender",
            className: "text-center",
            sortable: true,
        },
        {
            name: "Birth Date",
            data: "date_of_birth",
            className: "text-center",
            sortable: true,
        },
        {
            name: "Address",
            data: "address",
            className: "text-justify",
            sortable: true,
        },
        {
            name: "Phone Number",
            data: "phone_number",
            className: "text-center",
            sortable: true,
        },
        {
            name: "id",
            data: "id",
            className: "text-center",
            sortable: true,
            render: function (data) {
                return '<button class="btn btn-success btn-pilih" data-pasien="'+pasien_name+'" data-id="' + data + '" > <i class="bi bi-check"></i> Pilih</button>';
            },
        },
      ],
    });
  })
</script>