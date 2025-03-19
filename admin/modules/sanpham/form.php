<?php
$isEdit = isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] === 'sua' ? true : false;

?>

<div class="card card-primary" bis_skin_checked="1">
              <div class="card-header" bis_skin_checked="1">
                <h3 class="card-title"><?= $isEdit? "Sửa " : "Thêm "  ?>Sản Phẩm</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" novalidate="novalidate">
                <div class="card-body" bis_skin_checked="1">
                  <div class="form-group" bis_skin_checked="1">
                    <label for="product_namename">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
                  </div>
                  <div class="form-group" bis_skin_checked="1">
                    <label for="product_namename">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" bis_skin_checked="1">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>