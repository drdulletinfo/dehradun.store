<?php
  class Categories extends Controller {
    public function __construct(){
      if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
        // a simple check for admin. A more robust solution should be implemented
        // for a real world app.
        header('location: ' . URLROOT);
      }
      $this->categoryModel = $this->model('Category');
    }

    public function index(){
      // Get categories
      $categories = $this->categoryModel->getCategories();
      $data = [
        'categories' => $categories
      ];

      $this->view('categories/index', $data);
    }

    public function add(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'name' => trim($_POST['name']),
          'parent_id' => trim($_POST['parent_id']),
          'name_err' => '',
          'parent_id_err' => ''
        ];

        // Validate data
        if(empty($data['name'])){
          $data['name_err'] = 'Please enter name';
        }
        if(empty($data['parent_id'])){
            $data['parent_id_err'] = 'Please enter a parent id';
          }

        // Make sure no errors
        if(empty($data['name_err'])){
          // Validated
          if($this->categoryModel->addCategory($data)){
            header('location: ' . URLROOT . '/categories');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('categories/add', $data);
        }

      } else {
        $data = [
          'name' => '',
          'parent_id' => 0
        ];

        $this->view('categories/add', $data);
      }
    }

    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'id' => $id,
          'name' => trim($_POST['name']),
          'parent_id' => trim($_POST['parent_id']),
          'name_err' => '',
          'parent_id_err' => ''
        ];

        // Validate data
        if(empty($data['name'])){
            $data['name_err'] = 'Please enter name';
          }
          if(empty($data['parent_id'])){
              $data['parent_id_err'] = 'Please enter a parent id';
            }

        // Make sure no errors
        if(empty($data['name_err']) && empty($data['parent_id_err'])){
          // Validated
          if($this->categoryModel->updateCategory($data)){
            header('location: ' . URLROOT . '/categories');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('categories/edit', $data);
        }

      } else {
        // Get existing category from model
        $category = $this->categoryModel->getCategoryById($id);

        $data = [
          'id' => $id,
          'name' => $category->name,
          'parent_id' => $category->parent_id
        ];

        $this->view('categories/edit', $data);
      }
    }

    public function delete($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($this->categoryModel->deleteCategory($id)){
          header('location: ' . URLROOT . '/categories');
          } else {
            die('Something went wrong');
          }
      } else {
        header('location: ' . URLROOT . '/categories');
      }
    }
  }
