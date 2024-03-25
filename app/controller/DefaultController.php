<?php
require_once 'app/model/ProductModel.php';

class DefaultController {
    private $productModel;
    private $db;
    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index() {
        if(!SessionHelper::isLoggedIn()){
            header('Location: /BaiTapSang6/account/login');
        }
        $products = $this->productModel->readAll();
        include_once 'app/views/share/index.php';
    }

    public function logout() {
        SessionHelper::logout();
        header('Location: /BaiTapSang6/account/login');
        exit(); 
    }
}

