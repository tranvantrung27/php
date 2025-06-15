<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    // Hiển thị danh sách
    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    // Hiển thị form thêm mới
    public function add()
    {
        include 'app/views/category/add.php';
    }

    // Lưu dữ liệu thêm mới
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            if ($name) {
                $this->categoryModel->addCategory($name, $description);
            }
        }
        header('Location: /webbanhang/Category');
        exit();
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            include 'app/views/category/edit.php';
        } else {
            header('Location: /webbanhang/Category');
            exit();
        }
    }

    // Lưu dữ liệu sửa
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            if ($id && $name) {
                $this->categoryModel->updateCategory($id, $name, $description);
            }
        }
        header('Location: /webbanhang/Category');
        exit();
    }

    // Xóa danh mục
    public function delete($id)
    {
        if ($id) {
            $this->categoryModel->deleteCategory($id);
        }
        header('Location: /webbanhang/Category');
        exit();
    }
}
?>
