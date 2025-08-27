<?php require APPROOT . '/views/inc/header.php'; ?>
  <a href="<?php echo URLROOT; ?>/categories" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
  <div class="card card-body bg-light mt-5">
    <h2>Add Category</h2>
    <p>Create a new category</p>
    <form action="<?php echo URLROOT; ?>/categories/add" method="post">
      <div class="form-group">
        <label for="name">Name: <sup>*</sup></label>
        <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="parent_id">Parent ID: <sup>*</sup></label>
        <input type="number" name="parent_id" class="form-control form-control-lg <?php echo (!empty($data['parent_id_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['parent_id']; ?>">
        <span class="invalid-feedback"><?php echo $data['parent_id_err']; ?></span>
      </div>
      <input type="submit" class="btn btn-success" value="Submit">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
