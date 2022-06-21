<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="app-url" content="<?php echo base_url('/') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>


    <div class="container">
        <h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
        <div class="card">
            <div class="card-header">
                <button class="btn btn-outline-primary" onclick="createCategory()">
                    Create New Category
                </button>
                <a class="btn btn-outline-primary" href="<?php echo base_url('/') ?>">
                    Main
                </a>
                <a class="btn btn-outline-primary" href="<?php echo base_url('/index.php/list') ?>">
                    Shopping List
                </a>
            </div>
            <div class="card-body">
                <div id="alert-div">

                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th width="240px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="categories-table-body">

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- modal for creating and editing function -->
    <div class="modal" tabindex="-1" role="dialog" id="form-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Category Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modal-alert-div">

                    </div>
                    <form>
                        <input type="hidden" name="update_id" id="update_id">
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>

                        <button type="submit" class="btn btn-outline-primary" id="save-category-btn">Save Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- view record modal -->
    <div class="modal" tabindex="-1" role="dialog" id="view-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Category Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <b>Title:</b>
                    <p id="title-info"></p>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        showAllCategories();

        /*
            shows all records
        */
        function showAllCategories() {
            let url = $('meta[name=app-url]').attr("content") + "index.php/category/show_all";
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $("#categories-table-body").html("");
                    let category = response;
                    for (var i = 0; i < category.length; i++) {
                        let count = i + 1;
                        let showBtn = '<button ' +
                            ' class="btn btn-outline-info" ' +
                            ' onclick="showCategory(' + category[i].id + ')">Show' +
                            '</button> ';
                        let editBtn = '<button ' +
                            ' class="btn btn-outline-success" ' +
                            ' onclick="editCategory(' + category[i].id + ')">Edit' +
                            '</button> ';
                        let deleteBtn = '<button ' +
                            ' class="btn btn-outline-danger" ' +
                            ' onclick="destroyCategory(' + category[i].id + ')">Delete' +
                            '</button>';

                        let categoryRow = '<tr>' +
                            '<td>' + count + '</td>' +
                            '<td>' + category[i].title + '</td>' +
                            '<td>' + showBtn + editBtn + deleteBtn + '</td>' +
                            '</tr>';
                        $("#categories-table-body").append(categoryRow);
                    }


                },
                error: function(response) {
                    console.log(response)
                }
            });
        }

        /*
            check if form submitted is for creating or updating
        */
        $("#save-category-btn").click(function(event) {
            event.preventDefault();
            if ($("#update_id").val() == null || $("#update_id").val() == "") {
                storeCategory();
            } else {
                updateCategory();
            }
        })

        /*
            show modal for creating a record and 
            empty the values of form and remove existing alerts
        */
        function createCategory() {
            $("#alert-div").html("");
            $("#modal-alert-div").html("");
            $("#update_id").val("");
            $("#title").val("");
            $("#form-modal").modal('show');
        }

        /*
            submit the form and will be stored to the database
        */
        function storeCategory() {
            $("#save-category-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "index.php/category/store";
            let data = {
                title: $("#title").val()
            };
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function(response) {

                    $("#save-category-btn").prop('disabled', false);
                    let successHtml = '<div class="alert alert-success" role="alert"><b>Category Created Successfully</b></div>';
                    $("#alert-div").html(successHtml);
                    $("#title").val("");
                    showAllCategories();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    $("#save-category-btn").prop('disabled', false);

                    let responseData = JSON.parse(response.responseText);
                    console.log(responseData.errors);

                    if (typeof responseData.errors !== 'undefined') {
                        let errorHtml = '<div class="alert alert-danger" role="alert">' +
                            '<b>Validation Error!</b>' +
                            responseData.errors +
                            '</div>';
                        $("#modal-alert-div").html(errorHtml);
                    }
                }
            });
        }


        /*
            edit record function
            it will get the existing value and show the category form
        */
        function editCategory(id) {
            let url = $('meta[name=app-url]').attr("content") + "index.php/category/edit/" + id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    let category = response;
                    $("#alert-div").html("");
                    $("#modal-alert-div").html("");
                    $("#update_id").val(category.id);
                    $("#title").val(category.title);
                    $("#form-modal").modal('show');
                },
                error: function(response) {

                }
            });
        }

        /*
            sumbit the form and will update a record
        */
        function updateCategory() {
            $("#save-category-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "index.php/category/update/" + $("#update_id").val();
            let data = {
                id: $("#update_id").val(),
                title: $("#title").val(),
            };
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function(response) {
                    $("#save-category-btn").prop('disabled', false);
                    let successHtml = '<div class="alert alert-success" role="alert"><b>Category Updated Successfully</b></div>';
                    $("#alert-div").html(successHtml);
                    $("#title").val("");
                    showAllCategories();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    /*
                        show validation error
                    */
                    $("#save-category-btn").prop('disabled', false);

                    let responseData = JSON.parse(response.responseText);
                    console.log(responseData.errors);

                    if (typeof responseData.errors !== 'undefined') {
                        let errorHtml = '<div class="alert alert-danger" role="alert">' +
                            '<b>Validation Error!</b>' +
                            responseData.errors +
                            '</div>';
                        $("#modal-alert-div").html(errorHtml);
                    }
                }
            });
        }

        /*
            get and display the record info on modal
        */
        function showCategory(id) {
            $("#title-info").html("");
            let url = $('meta[name=app-url]').attr("content") + "index.php/category/show/" + id + "";
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    console.log(response);
                    let category = response;
                    $("#title-info").html(category.title);
                    $("#view-modal").modal('show');

                },
                error: function(response) {
                    console.log(response)
                }
            });
        }

        /*
            delete record function
        */
        function destroyCategory(id) {
            let url = $('meta[name=app-url]').attr("content") + "index.php/category/delete/" + id;
            let data = {
                title: $("#title").val(),
            };
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function(response) {
                    let successHtml = '<div class="alert alert-success" role="alert"><b>Category Deleted Successfully</b></div>';
                    $("#alert-div").html(successHtml);
                    showAllCategories();
                },
                error: function(response) {
                    console.log(response)
                }
            });
        }
    </script>
</body>

</html>