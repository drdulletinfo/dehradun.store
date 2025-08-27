<?php require APPROOT . '/views/inc/header.php'; ?>
  <a href="<?php echo URLROOT; ?>/listings" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
  <div class="card card-body bg-light mt-5">
    <h2>Add Listing</h2>
    <p>Create a new listing</p>
    <form action="<?php echo URLROOT; ?>/listings/add" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Title: <sup>*</sup></label>
        <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="description">Description: <sup>*</sup></label>
        <textarea name="description" class="form-control form-control-lg <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['description']; ?></textarea>
        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="category_id">Category: <sup>*</sup></label>
        <select name="category_id" class="form-control form-control-lg <?php echo (!empty($data['category_id_err'])) ? 'is-invalid' : ''; ?>">
          <option value="">Select a category</option>
          <?php foreach($data['categories'] as $category) : ?>
            <option value="<?php echo $category->id; ?>" <?php echo ($data['category_id'] == $category->id) ? 'selected' : ''; ?>><?php echo $category->name; ?></option>
          <?php endforeach; ?>
        </select>
        <span class="invalid-feedback"><?php echo $data['category_id_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="price">Price: <sup>*</sup></label>
        <input type="text" name="price" class="form-control form-control-lg <?php echo (!empty($data['price_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['price']; ?>">
        <span class="invalid-feedback"><?php echo $data['price_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="location">Location: <sup>*</sup></label>
        <input type="text" name="location" class="form-control form-control-lg <?php echo (!empty($data['location_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['location']; ?>">
        <span class="invalid-feedback"><?php echo $data['location_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="photos">Photos:</label>
        <input type="file" name="photos[]" class="form-control-file" multiple>
      </div>
      <input type="submit" class="btn btn-success" value="Submit">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
