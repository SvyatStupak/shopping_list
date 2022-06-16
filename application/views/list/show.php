<h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
<div class="card p-5">
    <div class="card-header">
        <a class="btn btn-outline-info float-right" href="<?php echo base_url('index.php/list'); ?>">
            View All Lists
        </a>
        <a class="btn btn-outline-info float-left" href="<?php echo base_url('index.php/list/edit/' . $list->id); ?>">
            Edit
        </a>
    </div>
    <div>
        
    </div>
    <table class="table w-50">
        <thead>
            <tr>
                <!-- <th scope="col">#</th> -->
                <th scope="col">Title</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">Category</th>
            </tr>
        </thead>
        <tr scope="row-6">
            <td><?php echo $list->title; ?></td>
            <td><?php echo $list->date_added; ?></td>
            <td><?php echo $list->status ? 'Bought' : 'Not Bought'; ?></td>
            <?php foreach ($category_lists as $key => $category_list) { ?>
                <td><?php echo $category_list->list_id == $list->category_id ? $category_list->cat_title : ''; ?></td>
            <?php } ?>
            
        </tr>

    </table>
</div>