<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<br>
<h1 class="mt-4"><?php echo $data['listing']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
  Listed by <?php echo $data['user']->name; ?> on <?php echo date('F j, Y', strtotime($data['listing']->created_at)); ?>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Main Image -->
        <img src="https://via.placeholder.com/700x450.png?text=Ad+Image" class="img-fluid mb-3" alt="Main Ad Image">

        <h4>Description</h4>
        <p><?php echo $data['listing']->description; ?></p>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                Price: ₹<?php echo number_format($data['listing']->price, 2); ?>
            </div>
            <div class="card-body">
                <p><strong>Category:</strong> <?php echo $data['category']->name; ?></p>
                <p><strong>Location:</strong> <i class="fa fa-map-marker"></i> <?php echo $data['listing']->location; ?></p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header bg-dark text-white">
                Seller Information
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?php echo $data['user']->name; ?></p>
                <p><strong>Email:</strong> <?php echo $data['user']->email; ?></p>
                <p><strong>Phone:</strong> <?php echo $data['user']->phone; ?></p>
                <button class="btn btn-primary btn-block">Contact Seller</button>
            </div>
        </div>
    </div>
</div>

<hr>
<!-- Edit/Delete Buttons for owner -->
<?php if($data['listing']->user_id == $_SESSION['user_id']) : ?>
  <a href="<?php echo URLROOT; ?>/listings/edit/<?php echo $data['listing']->id; ?>" class="btn btn-dark">Edit</a>

  <form class="pull-right" action="<?php echo URLROOT; ?>/listings/delete/<?php echo $data['listing']->id; ?>" method="post">
    <input type="submit" value="Delete" class="btn btn-danger">
  </form>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
