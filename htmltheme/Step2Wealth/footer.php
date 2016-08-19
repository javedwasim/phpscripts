	<!-- Footer-->
    <footer class="footer">
       © 2016 Step2Wealth
    </footer>

</div>

<!-- Vendor scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<!--<script src="vendor/jquery-flot/jquery.flot.js"></script>
<script src="vendor/jquery-flot/jquery.flot.resize.js"></script>
<script src="vendor/jquery-flot/jquery.flot.pie.js"></script>
<script src="vendor/flot.curvedlines/curvedLines.js"></script>
<script src="vendor/jquery.flot.spline/index.js"></script>-->
<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/peity/jquery.peity.min.js"></script>
<script src="vendor/sparkline/index.js"></script>
<script src="vendor/blueimp-gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
<script src="vendor/imsky-holder/holder.js"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
<!-- App scripts -->
<script src="scripts/homer.js"></script>
<script src="scripts/charts.js"></script>
<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<script src="vendor/toastr/build/toastr.min.js"></script>
<script src="scripts/steptwowealth.js"></script>
<!-- Local style for demo purpose -->
<style>

    .lightBoxGallery {
        text-align: center;
    }

    .lightBoxGallery a {
        margin: 5px;
        display: inline-block;
    }

</style>
<script>
    $(function () {
        
        // Initialize Example 1
        $('#example1').dataTable( {
            "ajax": 'api/datatables.json'
        });
         $('#referral_product').dataTable({
            "columnDefs": [
            {
                "targets": [0],
                "visible": false,
                "searchable": false,
            },]});
        $('#unlockcommission_product').dataTable({
            "columnDefs": [
            {
                "targets": [0],
                "visible": false,
                "searchable": false,
            },]});    
        // Initialize Example 2
        $('#example2').dataTable();
        $('.input-group.date').datepicker();
        $('#datapicker2').datepicker();
        $('#datapicker3').datepicker();

    });
</script>	

</body>
</html>