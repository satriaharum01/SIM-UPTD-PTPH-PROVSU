
<script>
  $(function () {
    let kode;
    let pasien_name;
  const table_pasien = $("#data-appointment").DataTable({
      searching: true,
      ajax: '{{ url("get/data/doctor/appointment/") }}',
      columns: [
        {
          data: "DT_RowIndex",
          name: "DT_RowIndex",
          className: "text-center",
        },
        {
            data: "kode",
            className: "text-center",
            sortable: true, render: function (data) { kode = data; return data;}
        },
        {
            data: "waktu",
            className: "text-center",
            sortable: true,
        },
        {
            data: "pasien",
            className: "text-center",
            sortable: true, render: function (data) { pasien_name = data; return data;}
        },
        {
            data: "notes",
            className: "text-justify",
            sortable: true,
        },
        {
            data: "id",
            className: "text-center",
            sortable: true,
            render: function (data) {
                return '<button class="btn btn-success btn-pilih" data-id="' + data + '"  data-kode="' + kode + '" data-pasien="' + pasien_name + '"> <i class="bi bi-check"></i> Pilih</button>';
            },
        },
      ],
    });
  })
</script>