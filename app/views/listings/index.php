<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Listings</h1>
    </div>
    <div class="col-md-6">
      <a href="<?php echo URLROOT; ?>/listings/add" class="btn btn-primary pull-right">
        <i class="fa fa-pencil"></i> Add Listing
      </a>
    </div>
  </div>
  <?php foreach($data['listings'] as $listing) : ?>
    <div class="card card-body mb-3">
      <h4 class="card-title"><?php echo $listing->title; ?></h4>
      <div class="bg-light p-2 mb-3">
        Listed by <?php echo $listing->name; ?> on <?php echo $listing->created_at; ?>
      </div>
      <p class="card-text"><?php echo $listing->description; ?></p>
      <a href="<?php echo URLROOT; ?>/listings/show/<?php echo $listing->listingId; ?>" class="btn btn-dark">More</a>
    </div>
  <?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
