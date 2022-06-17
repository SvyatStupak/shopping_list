<h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
<div class="card">
    <div class="card-header">
        <a class="btn btn-outline-info float-right" href="<?php echo base_url('index.php/list'); ?>">
            All Products
        </a>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('errors')) { ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('errors'); ?>
            </div>
        <?php } ?>
        <form action="<?php echo base_url('index.php/list/store'); ?>" method="POST">
            <div class="form-group w-25">
                <label for="name">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="title" value="<?php echo set_value('title'); ?>">
            </div>
             <div class="form-group">
            <select class="form-select" name="category_id">
                <option selected>Select Category</option>
             <?php foreach ($categories as $category) { ?> 
                <option value="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>
                <?php } ?>
            </select>
            </div>
            <button type="submit" class="btn btn-outline-primary">Add Product</button>
        </form>

    </div>
</div>

     
            
            