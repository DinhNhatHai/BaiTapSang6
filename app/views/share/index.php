<?php
include_once 'app/views/share/header.php';
?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Danh sách sản phẩm</h1>
<?php if(SessionHelper::isAdmin()): ?>
<a href="./product/add" class="btn btn-info btn-icon-split">   
    <span class="text">Thêm sản phẩm</span>
</a>
<?php endif; ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Dữ liệu</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $products->fetch(PDO::FETCH_ASSOC)) : ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['description'] ?></td>
                            <td><?= $row['price'] ?></td>
                            <td>
                                <?php
                                    if(empty($row['image'])){
                                        echo "No Image !!";
                                    }
                                    else{
                                        echo '<img src="' . $row["image"] . '" width="100" height="100" />';
                                    }
                                ?>                    
                            </td>
                            <td>
                                <?php if(SessionHelper::isAdmin()): ?>
                                    <a class="btn btn-warning" href="/BaiTapSang6/product/edit/<?= $row['id'] ?>">
                                            <i class="fas fa-edit">

                                            </i>
                                    </a>
                                    <a class="btn btn-danger" href="/BaiTapSang6/product/delete?id=<?= $row['id'] ?>" >
                                        <i class="fas fa-trash"></i> 
                                    </a>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once 'app/views/share/footer.php';
?>