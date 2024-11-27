
<script>
  $(function () {
    let kode;
  const table_pasien = $("#data-appointment").DataTable({
      searching: true,
      ajax: '{{ url("get/data/appointment/") }}/'+patient_id,
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
            data: "dokter",
            className: "text-center",
            sortable: true,
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
                return '<button class="btn btn-success btn-pilih" data-id="' + data + '"  data-kode="' + kode + '"> <i class="bi bi-check"></i> Pilih</button>';
            },
        },
      ],
    });
  })
</script>