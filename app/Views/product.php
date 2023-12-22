<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <h1 class="m-0">PRODUCT </h1>
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <?php if (isset($edituser)) {
                                            echo 'EDIT PRODUCT';
                                        } else {
                                            echo 'ADD PRODUCT';
                                        } ?>
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <?= view('validation_error'); ?>
                                <?= view('flash_message'); ?>

                                <form action="<?php if (!isset($editproduct)) {
                                    echo base_url('product');
                                } ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php if (isset($editproduct)) {
                                        echo $editproduct['id'];
                                    } ?>">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="date" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="date" name="date" value="<?php if (isset($editproduct)) {
                                                echo $editproduct['date'];
                                            } else {
                                                echo date('Y-m-d');
                                            } ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="Username" class="form-label">category</label>
                                            <select class="form-control" name="category_id" id="category">
                                                <option value="">Select a category</option>
                                                <?php
                                                foreach ($categories as $value) {
                                                    ?>
                                                    <option value="<?= $value['id']; ?>" <?php if (isset($editproduct) && $value['id'] == $editproduct['category_id']) {
                                                          echo 'selected';
                                                      } ?>><?= $value['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">Name</label>
                                            <input type="name" class="form-control" id="name" placeholder="Enter Name"
                                                name="name" value="<?php if (isset($editproduct)) {
                                                    echo $editproduct['name'];
                                                } ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="mobileno" class="form-label">Image</label>
                                            <input type="file" class="form-control" id="image" name="image" value="<?php if (isset($editproduct)) {
                                                echo $editproduct['image'];
                                            } ?>" if(!isset($editproduct){echo required;})>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                    <div class=" card-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <?php if (isset($editproduct)) {
                                                echo 'UPDATE PRODUCT';
                                            } else {
                                                echo 'ADD PRODUCT';
                                            } ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
            </section>
            <div class="col-sm-12">
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-sm-12">
                <div class="card mx-4">
                    <div class="card-header">
                        <h3 class="card-title">View PRODUCT </h3>
                    </div>
                    <div class="card-body border-bottom">
                        <div class="table-responsive">
                            <table id="example1" class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>Serial No </th>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th>category</th>
                                        <th>name</th>
                                        <th>Image</th>
                                        <th>Created At</th>
                                        <th>Updated at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    if (count($product)) {
                                        foreach ($product as $data) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?= $i++ ?>
                                                </td>
                                                <td>
                                                    <div>
                                                        <a class="btn btn-primary"
                                                            href="<?= base_url('editproduct/') . $data['id'] ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-edit " width="24"
                                                                height="24" viewBox="0 0 25 25" stroke-width="2"
                                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path
                                                                    d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                                </path>
                                                                <path
                                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                                </path>
                                                                <path d="M16 5l3 3"></path>
                                                            </svg>
                                                        </a>
                                                        <a class="btn btn-danger"
                                                            href="<?= base_url('deleteproduct/') . $data['id'] ?>"
                                                            onclick="return confirm('Are you sure you want to delete?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-trash-off" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M3 3l18 18" />
                                                                <path d="M4 7h3m4 0h9" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 14l0 3" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l.077 -.923" />
                                                                <path d="M18.384 14.373l.616 -7.373" />
                                                                <path d="M9 5v-1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?= $data['date']; ?>
                                                </td>
                                                <td>
                                                    <?= $data['category']; ?>
                                                </td>
                                                <td>
                                                    <?= $data['name']; ?>
                                                </td>
                                                <td>
                                                    <img src="<?= base_url('uploads/' . $data['image']) ?>"
                                                        alt="<?= $data['name'] ?> width=" 100" height="60">
                                                </td>
                                                <td>
                                                    <?= $data['created_at']; ?>
                                                </td>
                                                <td>
                                                    <?= $data['updated_at']; ?>
                                                </td>
                                            </tr>
                                        <?php }
                                    } ?>
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

<?= $this->endsection(); ?>