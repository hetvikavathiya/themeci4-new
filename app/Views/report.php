<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-sm-12">
                    <div class="card mx-4">
                        <div class="card-header">
                            <h3 class="card-title">View Product Report </h3>
                        </div>
                        <div class="card-body border-bottom">
                            <div class="table-responsive">
                                <table id="product" class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                        <tr>
                                            <th>Serial No </th>
                                            <th>Action</th>
                                            <th>Date</th>
                                            <th>category</th>
                                            <th>name</th>
                                            <th>Image</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var table = $('#product').DataTable({
            "iDisplayLength": 5,
            "lengthMenu": [
                [5, 10, 25, 50, 100, 500, 1000, 5000],
                [5, 10, 25, 50, 100, 500, 1000, 5000]
            ],
            'processing': true,
            'serverSide': true,
            'destroy': true,
            'serverMethod': 'post',
            'searching': true,
            "ajax": {
                'url': "<?= base_url('getlist'); ?>", // Replace with your actual route
                'type': 'POST', // Use POST method
                'data': function (data) {
                    data.filterstatus = $('#filterstatus').val();
                    data.todate = $('#todate').val();
                    data.fromdate = $('#fromdate').val();
                }
            },

            "columns": [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'action',
                name: 'action',
            },
            {
                data: 'category',
                name: 'category'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'image',
                name: 'image'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'updated_at',
                name: 'updated_at'
            },
            ],
        });
        User
        $('#filterstatus').on('change', function () {
            table.clear()
            table.draw()
        });
        $('#todate').on('change', function () {
            table.clear()
            table.draw()
        });
        $('#fromdate').on('change', function () {
            table.clear()
            table.draw()
        });
    });
</script>

<?= $this->endsection(); ?><!-- Make sure you have included jQuery and DataTables scripts in your HTML -->