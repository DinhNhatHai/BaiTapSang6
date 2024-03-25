<?php include_once 'app/views/share/header.php'; ?>

<?php
    if(isset($err)){
        echo "<ul>";
        foreach ($err as $errors){
            echo "<li> $errors</li>";
        }
        echo "<ul>";
    }
?>

<form action="/BaiTapSang6/product/update" method="post" class="user" enctype="multipart/form-data">

    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <input value="<?= $product->name ?>" type="text" class="form-control form-control-user" placeholder="Product Name" name="name">
        </div>

        <div class="col-sm-6">
            <input value="<?= $product->description ?>" type="text" class="form-control form-control-user" placeholder="Description" name="description">
        </div>
    </div>
    <div class="form-group">
        <input value="<?= $product->price ?>" type="text" class="form-control form-control-user" placeholder="Price" name="price">
    </div>
    <?php if(empty($product->image)): ?>
        <p>No Image !!</p>
    <?php else: ?>
        <img src="<?= $product->image ?>" width="100" height="100" alt="Product Image">
    <?php endif; ?>
    <div class="form-group">
        <label for="image">Upload New Image:</label>
        <input type="file" class="form-control-file" id="image" name="image">
    </div>
    <input type="hidden" name="product_id" value="<?= $product->id ?>">
    <button type="submit" class="btn btn-primary btn-user btn-block">Update Product</button>
</form>

<?php include_once 'app/views/share/footer.php'; ?>
