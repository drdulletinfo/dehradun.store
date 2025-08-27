<?php
  class Listing {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getListings(){
      $this->db->query('SELECT *,
                        listings.id as listingId,
                        users.id as userId
                        FROM listings
                        INNER JOIN users ON listings.user_id = users.id
                        ORDER BY listings.created_at DESC');

      $results = $this->db->resultSet();

      return $results;
    }

    public function addListing($data){
      $this->db->query('INSERT INTO listings (title, description, category_id, user_id, price, photos, location) VALUES(:title, :description, :category_id, :user_id, :price, :photos, :location)');
      // Bind values
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':description', $data['description']);
      $this->db->bind(':category_id', $data['category_id']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':price', $data['price']);
      $this->db->bind(':photos', $data['photos']);
      $this->db->bind(':location', $data['location']);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function getListingById($id){
      $this->db->query('SELECT * FROM listings WHERE id = :id');
      $this->db->bind(':id', $id);

      $row = $this->db->single();

      return $row;
    }

    public function updateListing($data){
      $this->db->query('UPDATE listings SET title = :title, description = :description, category_id = :category_id, price = :price, photos = :photos, location = :location WHERE id = :id');
      // Bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':description', $data['description']);
      $this->db->bind(':category_id', $data['category_id']);
      $this->db->bind(':price', $data['price']);
      $this->db->bind(':photos', $data['photos']);
      $this->db->bind(':location', $data['location']);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function deleteListing($id){
      $this->db->query('DELETE FROM listings WHERE id = :id');
      // Bind values
      $this->db->bind(':id', $id);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }
