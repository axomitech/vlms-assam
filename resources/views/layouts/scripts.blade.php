<!-- DataTables  & Plugins -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('js/custom/common.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-3d"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    // Show the loading overlay
    function showLoading() {
        $('#loading-overlay').show(); // Show loading spinner and text
    }

    // Hide the loading overlay
    function hideLoading() {
        $('#loading-overlay').hide(); // Hide loading spinner and text
    }

    // Handle Read More/Read Less click
    $(document).on('click', '.readMore', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $(`#textBlock${id} .shortText`).hide();
        $(`#textBlock${id} .longText`).show();
    });

    $(document).on('click', '.readLess', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $(`#textBlock${id} .shortText`).show();
        $(`#textBlock${id} .longText`).hide();
    });
</script>
