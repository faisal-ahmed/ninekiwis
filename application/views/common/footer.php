</div>

<div class="clearfix"></div>

<div class="row footer">
    <div class="col-lg-10 col-md-offset-1">
        <hr/>
        <h4 class="text-center" style="font-weight: bold;">Copyright &copy; <?php echo date("Y"); ?> ninekiwis.de</h4>
        <h5 class="text-center" style="font-weight: bold;">Developed by Mohammad Faisal Ahmed</h5>
    </div>
    <!-- /.col-lg-12 -->
</div>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url() ?>static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url() ?>static/bower_components/metisMenu/dist/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="<?php echo base_url() ?>static/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>static/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

<?php if (isset($pageType) && $pageType == 'loanStat') { ?>
    <!-- Flot Charts JavaScript -->
    <script src="<?php echo base_url() ?>static/bower_components/flot/excanvas.min.js"></script>
    <script src="<?php echo base_url() ?>static/bower_components/flot/jquery.flot.js"></script>
    <script src="<?php echo base_url() ?>static/bower_components/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url() ?>static/bower_components/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo base_url() ?>static/bower_components/flot/jquery.flot.time.js"></script>
    <script src="<?php echo base_url() ?>static/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo base_url() ?>static/js/flot-data.js"></script>
<?php } ?>

<!-- Custom static JavaScript -->
<script src="<?php echo base_url() ?>static/dist/js/sb-admin-2.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script type="text/javascript">
    $(document).ready(function() {
        if (typeof dataTable != 'undefined'){
            $('#' + dataTable).DataTable({
                responsive: true,
                "lengthMenu": [ 5, 10, 25, 50, 75, 100, 500 ],
                "order": [[ 1, "desc" ]]
            });
        }
    });
</script>

</body>

</html>