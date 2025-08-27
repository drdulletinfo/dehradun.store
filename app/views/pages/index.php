<?php require APPROOT . '/views/inc/header.php'; ?>

  <div class="jumbotron jumbotron-fluid text-center">
    <div class="container">
      <h1 class="display-3"><?php echo $data['title']; ?></h1>
      <p class="lead"><?php echo $data['description']; ?></p>
    </div>
  </div>

  <!-- Search Bar -->
  <div class="row mb-4">
    <div class="col-md-12">
      <form class="form-inline" action="<?php echo URLROOT; ?>/listings/search" method="get">
        <input class="form-control mr-sm-2 col-md-5" type="search" name="keyword" placeholder="Keyword (e.g. Honda Civic)" aria-label="Search">
        <select name="category" class="form-control mr-sm-2 col-md-3">
          <option value="">All Categories</option>
          <?php
            // In a real app, you'd fetch these from the db
            $categories = ['Vehicles', 'Real Estate', 'Jobs', 'Services', 'Electronics'];
            foreach($categories as $category): ?>
            <option value="<?php echo strtolower($category); ?>"><?php echo $category; ?></option>
          <?php endforeach; ?>
        </select>
        <input class="form-control mr-sm-2 col-md-2" type="text" name="location" placeholder="Location" aria-label="Location">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </div>

  <h2 class="mb-4">Latest Listings</h2>

  <div class="row">
    <?php if (is_array($data['listings']) && !empty($data['listings'])): ?>
      <?php foreach($data['listings'] as $listing) : ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img class="card-img-top" src="https://via.placeholder.com/300x200.png?text=Ad+Image" alt="<?php echo $listing->title; ?>">
            <div class="card-body">
              <h5 class="card-title"><a href="<?php echo URLROOT; ?>/listings/show/<?php echo $listing->listingId; ?>"><?php echo $listing->title; ?></a></h5>
              <h6 class="card-subtitle mb-2 text-muted">₹<?php echo number_format($listing->price, 2); ?></h6>
              <p class="card-text"><?php echo substr($listing->description, 0, 80); ?>...</p>
              <small class="text-muted"><i class="fa fa-map-marker"></i> <?php echo $listing->location; ?></small>
            </div>
            <div class="card-footer">
                <small class="text-muted">Posted on: <?php echo date('F j, Y', strtotime($listing->created_at)); ?></small>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col">
        <p>No listings found. Be the first to post an ad!</p>
      </div>
    <?php endif; ?>
  </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
