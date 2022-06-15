<h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
<div class="card">
    <div class="card-header">
        <a class="btn btn-outline-primary" href="<?php echo base_url('index.php/category/create'); ?>">
            Cretate Category
        </a>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>

        <h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
 
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th width="240px">Action</th>
            </tr>
 
            <?php foreach ($categories as $category) { ?>      
            <tr>
                <td><?php echo $category->id; ?></td>
                <td><?php echo $category->title; ?></td>          
                <td>
                    <a
                        class="btn btn-outline-info"
                        href="<?php echo base_url('index.php/category/show/'. $category->id) ?>"> 
                        Show
                    </a>
                    <a
                        class="btn btn-outline-success"
                        href="<?php echo base_url('index.php/category/edit/'.$category->id) ?>"> 
                        Edit
                    </a>
                    <a
                        class="btn btn-outline-danger"
                        href="<?php echo base_url('index.php/category/delete/'.$category->id) ?>"> 
                        Delete
                    </a>
                </td>     
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
    </div>
</div>