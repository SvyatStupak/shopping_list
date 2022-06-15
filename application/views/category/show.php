<h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
<div class="card">
    <div class="card-header">
        <a class="btn btn-outline-info float-right" href="<?php echo base_url('index.php/category'); ?>">
            View All Categories
        </a>
    </div>
    <table class="table w-50">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
            </tr>
        </thead>
        <tr scope="row-6">
            <td><?php echo $category->id; ?></td>
            <td><?php echo $category->title; ?></td>

        </tr>

    </table>
</div>