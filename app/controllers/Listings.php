<?php
  class Listings extends Controller {
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        header('location: ' . URLROOT . '/users/login');
      }

      $this->listingModel = $this->model('Listing');
      $this->userModel = $this->model('User');
      $this->categoryModel = $this->model('Category');
    }

    public function index(){
      // Get listings
      $listings = $this->listingModel->getListings();

      $data = [
        'listings' => $listings
      ];

      $this->view('listings/index', $data);
    }

    public function add(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'title' => trim($_POST['title']),
          'description' => trim($_POST['description']),
          'category_id' => trim($_POST['category_id']),
          'price' => trim($_POST['price']),
          'location' => trim($_POST['location']),
          'photos' => '', // handle file uploads separately
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'description_err' => '',
          'category_id_err' => '',
          'price_err' => '',
          'location_err' => ''
        ];

        // Validate data
        if(empty($data['title'])){
          $data['title_err'] = 'Please enter title';
        }
        if(empty($data['description'])){
          $data['description_err'] = 'Please enter description';
        }
        if(empty($data['category_id'])){
          $data['category_id_err'] = 'Please select a category';
        }
        if(empty($data['price'])){
            $data['price_err'] = 'Please enter a price';
          }
        if(empty($data['location'])){
            $data['location_err'] = 'Please enter a location';
        }

        // Make sure no errors
        if(empty($data['title_err']) && empty($data['description_err']) && empty($data['category_id_err']) && empty($data['price_err']) && empty($data['location_err'])){
          // Validated
          if($this->listingModel->addListing($data)){
            header('location: ' . URLROOT . '/listings');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $categories = $this->categoryModel->getCategories();
          $data['categories'] = $categories;
          $this->view('listings/add', $data);
        }

      } else {
        $categories = $this->categoryModel->getCategories();
        $data = [
          'title' => '',
          'description' => '',
          'category_id' => '',
          'price' => '',
          'location' => '',
          'categories' => $categories
        ];

        $this->view('listings/add', $data);
      }
    }

    public function show($id){
        $listing = $this->listingModel->getListingById($id);
        $user = $this->userModel->getUserById($listing->user_id);
        $category = $this->categoryModel->getCategoryById($listing->category_id);

        $data = [
          'listing' => $listing,
          'user' => $user,
          'category' => $category
        ];

        $this->view('listings/show', $data);
      }
  }
