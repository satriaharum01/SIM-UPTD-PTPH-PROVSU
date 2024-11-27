  <!-- jQuery Toastr -->
  <script src="<?= asset('static/assets/js/toastr.js') ?>"></script>
  <!-- Essential javascripts for application to work-->
  <script src="{{asset('static/js/jquery-3.7.0.min.js')}}"></script>
  <script src="{{asset('static/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('static/js/main.js')}}"></script>
  <!-- Page specific javascripts-->
  <link  rel="stylesheet"  href="{{asset('static/css/datatables.min.css')}}"/>
  <!-- Data table plugin-->
  <script type="text/javascript" src="{{asset('static/js/plugins/jquery.dataTables.min.js')}}"></script>
  <!-- Select 2 Plugin -->
  <script src="{{asset('static/assets/select2/select2.min.js')}}"></script>
  <!-- Money Format plugins -->
  <script src="{{asset('static/assets/js/chart.js/chart.js')}}"></script>
  <script src="{{asset('static/assets/js/dashboard-chart-area.js')}}"></script>
  <script type="text/javascript">
    @if (session('message'))
        <?php switch (session('info')) {
            case "success":
                ?>
                toastr.success('<?= session('message') ?>');
            <?php break;
            case "info":
                ?>
                toastr.info('<?= session('message') ?>');
            <?php break;
            case "error": ?>
                toastr.error('<?= session('message') ?>');
            <?php break;
            default: ?>
                toastr.warning('<?= session('message') ?>');
        <?php }; ?>
    @endif
    $(document).ready(function() {
      
      $('.select-2-control').select2({
        dropdownParent: $("#compose")
      });
      
      $('.select-2-form').select2();

      $('#basic-datatables').DataTable({
      });

      $('#multi-filter-select').DataTable( {
        "pageLength": 5,
        initComplete: function () {
          this.api().columns().every( function () {
            var column = this;
            var select = $('<select class="form-control"><option value=""></option></select>')
            .appendTo( $(column.footer()).empty() )
            .on( 'change', function () {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
                );

              column
              .search( val ? '^'+val+'$' : '', true, false )
              .draw();
            } );

            column.data().unique().sort().each( function ( d, j ) {
              select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
          } );
        }
      });

      // Add Row
      $('#add-row').DataTable({
        "pageLength": 5,
      });

      var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

      $('#addRowButton').click(function() {
        $('#add-row').dataTable().fnAddData([
          $("#addName").val(),
          $("#addPosition").val(),
          $("#addOffice").val(),
          action
          ]);
        $('#addRowModal').modal('hide');

      });
    });
  </script>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Page level plugins -->
    <script src="{{asset('static/assets/js/chart.js/Chart.min.js')}}"></script>
    <!-- Money Format plugins -->
    <script src="{{asset('static/assets/js/dashboard-chart-area.js')}}"></script>
    <script>
        $(function () {
        $(".alert").fadeOut(3000);
        });
        $("body").on("click", ".btn-hapus", function() {
            var x = jQuery(this).attr("data-id");
            var y = jQuery(this).attr("data-handler");
            var xy = x + '-' + y;
            event.preventDefault()
            Swal.fire({
                title: 'Hapus Data ?',
                text: "Data yang dihapus tidak dapat dikembalikan !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Data Dihapus!',
                        '',
                        'success'
                    );
                    document.getElementById('delete-form-' + xy).submit();
                }
            });
        })
        $("body").on("click", ".btn-reject", function() {
            var x = jQuery(this).attr("data-id");
            var y = jQuery(this).attr("data-handler");
            var xy = x + '-' + y;
            event.preventDefault()
            Swal.fire({
                title: 'Tolak Appointment ?',
                text: "Hubungi admin untuk perubahan data lebih lanjut !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Appointment Ditolak!',
                        '',
                        'success'
                    );
                    document.getElementById('reject-form-' + xy).submit();
                }
            });
        })
        $("body").on("click", ".btn-confirm", function() {
            var x = jQuery(this).attr("data-id");
            var y = jQuery(this).attr("data-handler");
            var xy = x + '-' + y;
            event.preventDefault()
            Swal.fire({
                title: 'Selesaikan Appointment ?',
                text: "Hubungi admin untuk perubahan data lebih lanjut !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Appointment Diterima!',
                        '',
                        'success'
                    );
                    document.getElementById('confirm-form-' + xy).submit();
                }
            });
        })
        function fetch_data(category, binding){
          $.ajax({
                url: '{{ url("get/data") }}/'+category,
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) { 
                    binding = dataResult;
                }
          });
        }
    </script>
  
  @if(Auth::user()->level == '')
    <script type="text/javascript">
        var count_notif = 0;
        var current_notif = 1;
        window.onload = function() { 
            get_notif(); 
        }
       
        function get_notif() {
            $.ajax({
                url: "<?=url('/robot/notif/get/');?>",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (dataResult) { 
                    console.log(dataResult);
                    var resultData = dataResult.data;
                    if(resultData.length > 0)
                    {
                        jQuery('#badge-counter').removeClass();
                        jQuery('#badge-counter').addClass("count bg-success badge-counter");
                        $("#notificationDropdown").attr('data-toggle','dropdown');
                        $('#alertsDropdownList').html("");
                        $('#alertsDropdownList').append('<a class="dropdown-item py-3 border-bottom">\
                          <p class="mb-0 font-weight-medium float-left badge-counter-list">4 new notifications </p>\
                          <span class="badge badge-pill badge-primary float-right btn-logs">View all</span>\
                        </a>');
                        $("#alertsDropdownList").prop('hidden',false);
                        jQuery('.badge-counter').html(resultData.length);
                        jQuery('.badge-counter-list').html(resultData.length+ ' new notification');
                       var i = 1;
                        $.each(resultData,function(index,row){
                            if(i <= 6)
                            {
                            $('#alertsDropdownList').append('<a class="dropdown-item preview-item py-3">\
                                <div class="preview-thumbnail mr-2">\
                                  <i class="mdi '+row.icon+' m-auto text-'+row.color+'"></i>\
                                </div>\
                                <div class="col-md-12 preview-item-content">\
                                  <h6 class="preview-subject font-weight-normal text-dark mb-1">'+row.judul+'</h6>\
                                  <p class="font-weight-light float-right small-text mx-3 mb-0">'+row.akun+' - '+row.waktu+' </p>\
                                </div>\
                              </a>'
                            );
                            }
                            i++;
                        })
                    }else if(resultData.length === 0){
                        jQuery('#badge-counter').removeClass();
                        jQuery('#badge-counter').addClass("badge-counter");
                        $("#notificationDropdown").removeAttr('data-toggle');
                        $("#alertsDropdownList").prop('hidden',true);
                        $('#alertsDropdownList').html("");
                        jQuery('.badge-counter').html("");
                    }
                    current_notif = resultData.length;
                }
            });
            setTimeout('get_notif()', 5000);
        }
      </script>
    @endif
