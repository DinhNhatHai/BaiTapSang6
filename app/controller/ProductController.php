<?php
require_once 'app/model/ProductModel.php';
class ProductController {
    private $productModel;
    private $db;
    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    public function listProducts() {

        $stmt = $this->productModel->readAll();
        
        include_once 'app/views/product_list.php';
    }
    public function add(){
        include_once 'app/views/product/add.php';
    }
    public function uploadImage($file) {
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
        // Kiểm tra xem file có phải là hình ảnh thực sự hay không
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    
        // Kiểm tra kích thước file
        if ($file["size"] > 500000) { // Ví dụ: giới hạn 500KB
            $uploadOk = 0;
        }
    
        // Kiểm tra định dạng file
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }
    
        // Kiểm tra nếu $uploadOk bằng 0
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                return $targetFile;
            } else {
                return false;
            }
        }
    }

    public function save() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
    
            $defaultImage = "path/to/default/image.jpg"; 
            $uploadedImagePath = $defaultImage;
    
            if(isset($_FILES['image'])){
                $uploadResult = $this->uploadImage($_FILES['image']);
                if($uploadResult){
                    $uploadedImagePath = $uploadResult;
                }
            }
            $productModel = new ProductModel($this->db);
            $result = $productModel->createProduct($name, $description, $price, $uploadedImagePath);
    
            if(is_array($result)){
                $err = $result;
                include 'app/views/product/add.php';
            } else {
                header('Location: /BaiTapSang6');
            }
        }
    }
    public function edit($id) {
        $product = $this->productModel->getproductById($id);
        if($product){
            include_once  'app/views/product/edit.php';

        }else {
            include_once  'app/views/product/Not-found.php';

        }
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $productId = $_POST['product_id'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
    
            // Handle image upload if provided
            $uploadedImagePath = ''; // Default value if no image uploaded
            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Upload image and get the path
                $uploadedImagePath = $this->uploadImage($_FILES['image']);
            }
    
            // Update product in database
            $productModel = new ProductModel($this->db);
            $result = $productModel->updateProduct($productId, $name, $description, $price, $uploadedImagePath);
    
            if(is_array($result)) {
                // Handle errors
                $err = $result;
                include 'app/views/product/edit.php';
            } else {
                // Redirect to product list page
                header('Location: /BaiTapSang6');
            }
        }
    }
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            
            $productModel = new ProductModel($this->db);
            $result = $productModel->deleteProduct($id);
            
            if ($result) {
                header('Location: /BaiTapSang6');
            } else {

                echo "Failed to delete product.";
            }
        }
    }
}
    
