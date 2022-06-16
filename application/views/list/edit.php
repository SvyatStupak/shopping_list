<h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
<div class="card">
    <div class="card-header">
        <a class="btn btn-outline-info float-right" href="<?php echo base_url('index.php/category'); ?>">
            View All Products
        </a>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('errors')) { ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('errors'); ?>
            </div>
        <?php } ?>

        <form action="<?php echo base_url('index.php/list/update/' . $list->id); ?>" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group w-25">
                <label for="name">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="title" value="<?php echo $list->title; ?>">
            </div>
            <div class="form-group w-25">
                <select class="form-select" name="status">
                    <!-- <option selected>Change status</option> -->
                    <option value="0" 
                    <?php if ($list->status == 0) { ?>
                        selected
                    <?php } ?>
                    >Not Bought</option>
                    <option value="1" 
                    <?php if ($list->status == 1) { ?>
                        selected
                    <?php } ?>
                    >Bought</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-select" name="category_id">
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category->id; ?>" <?php echo $category->id == $list->category_id ? 'selected' : '' ?>>
                            <?php echo $category->title; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-outline-primary">Save Category</button>
    </div>
    </form>

</div>
</div>