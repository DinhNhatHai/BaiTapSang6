<?php
include_once 'app/views/share/header.php';
?>

<?php
    if(isset($err)){
        echo "<ul>";
        foreach ($err as $errors){
            echo "<li> $errors</li>";
        }
        echo "<ul>";
    }
?>
<form action="/BaiTapSang6/product/save" method="post" class="user" enctype="multipart/form-data">
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <input type="text" class="form-control form-control-user" placeholder="Product Name" name="name">
        </div>

        <div class="col-sm-6">
            <input type="text" class="form-control form-control-user" placeholder="Description" name="description">
        </div>
    </div>
    <div class="form-group">
        <input type="text" class="form-control form-control-user" placeholder="Price" name="price">
    </div>
    <div class="input-group mb-3">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputGroupFile02" name="image">
            <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-user btn-block">Save Product</button>
</form>

<?php
include_once 'app/views/share/footer.php';
?>
