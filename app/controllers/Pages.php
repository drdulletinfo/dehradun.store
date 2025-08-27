<?php
class Pages extends Controller {
    public function __construct(){
        $this->listingModel = $this->model('Listing');
    }

    public function index(){
        $listings = $this->listingModel->getListings();
        $data = [
            'title' => 'Welcome To Dehradun Classifieds',
            'description' => 'Find the latest classified ads in Dehradun and the surrounding area.',
            'listings' => $listings
        ];

        $this->view('pages/index', $data);
    }

    // about page is not in the plan, but it was in the navbar
    // so I will add it here.
    public function about(){
        $data = [
            'title' => 'About Us',
            'description' => 'A simple classifieds ads platform for Dehradun.'
        ];

        $this->view('pages/about', $data);
    }
}
