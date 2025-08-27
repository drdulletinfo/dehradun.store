<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Categories</h1>
    </div>
    <div class="col-md-6">
      <a href="<?php echo URLROOT; ?>/categories/add" class="btn btn-primary pull-right">
        <i class="fa fa-pencil"></i> Add Category
      </a>
    </div>
  </div>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Parent ID</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
  <?php foreach($data['categories'] as $category) : ?>
    <tr>
      <td><?php echo $category->id; ?></td>
      <td><?php echo $category->name; ?></td>
      <td><?php echo $category->parent_id; ?></td>
      <td>
        <a href="<?php echo URLROOT; ?>/categories/edit/<?php echo $category->id; ?>" class="btn btn-dark">Edit</a>
        <form class="pull-right" action="<?php echo URLROOT; ?>/categories/delete/<?php echo $category->id; ?>" method="post">
          <input type="submit" value="Delete" class="btn btn-danger">
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
    </tbody>
  </table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
