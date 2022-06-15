<h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
<div class="card">
    <div class="card-header">
        <a class="btn btn-outline-info float-right" href="<?php echo base_url('index.php/category'); ?>">
            View All Categories
        </a>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('errors')) { ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('errors'); ?>
            </div>
        <?php } ?>

        <form action="<?php echo base_url('index.php/category/update/' . $category->id); ?>" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label for="name">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $category->title; ?>">
            </div>
            <button type="submit" class="btn btn-outline-primary">Save Category</button>
        </form>

    </div>
</div>