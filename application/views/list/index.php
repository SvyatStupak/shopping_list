<h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
<div class="card">
    <div class="card-header">
        <a class="btn btn-outline-primary" href="<?php echo base_url('index.php/list/create'); ?>">
            Add Products
        </a>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>

 
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Date</th>
                <th>Status</th>
                <th>Category</th>
                <th width="240px">Action</th>
            </tr>
 
            <?php foreach ($lists as $key => $list) { ?>      
            <tr>
                <td><?php echo $key + 1; ?></td>
                <td><?php echo $list->title; ?></td>          
                <td><?php echo $list->date_added; ?></td>          
                <td><?php 
                    echo $list->status ? 'Bought' : 'Not bought';
                    ?>
                </td>
                <td><?php 
                    foreach ($category_lists as $category_list) { 
                        echo $list->id == $category_list->list_id ? $category_list->cat_title : '';
                    }
                    ?>
                </td>

                <td>
                    <a
                        class="btn btn-outline-info"
                        href="<?php echo base_url('index.php/list/show/'.$list->id) ?>"> 
                        Show
                    </a>
                    <a
                        class="btn btn-outline-success"
                        href="<?php echo base_url('index.php/list/edit/'.$list->id) ?>"> 
                        Edit
                    </a>
                    <a
                        class="btn btn-outline-danger"
                        href="<?php echo base_url('index.php/list/delete/'.$list->id) ?>"> 
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