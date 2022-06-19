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
                <button class="btn btn-outline-primary" onclick="createShoppingList()">
                    Create New List
                </button>
                <a class="btn btn-outline-primary" href="<?php echo base_url('/') ?>">
                    Main
                </a>
            </div>
            <div class="card-body">
                <div id="alert-div">

                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>
                                <select name="catStatus" id="catStatus">
                                    <option value="" selected>All statuses</option>
                                    <option value="unfinished">unfinished</option>
                                    <option value="bought">bought</option>
                                </select>
                            </th>
                            <th>
                                <select name="catFilter" id="catFilter">
                                    <option value="" selected>All categories</option>
                                </select>
                            </th>
                            <th width="240px">Action</th>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th width="240px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="lists-table-body">

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
                    <h5 class="modal-title">Shopping List Form</h5>
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
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="category_id">Choise category</label>
                            <div>
                                <select class="form-select" name="category_id" id="category_id">

                                </select>
                                <div class="form-group">
                                    <label for="status">Choise category</label>
                                    <div>
                                        <select class="form-select" name="status" id="status">
                                            <option value="0">unfinished</option>
                                            <option value="1">bought</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary" id="save-shoppinglist-btn">Save List</button>
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
                    <h5 class="modal-title">List Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <b>Title:</b>
                    <p id="title-info"></p>
                    <b>Date:</b>
                    <p id="date-info"></p>
                    <b>Status:</b>
                    <p id="status-info"></p>
                    <b>Category:</b>
                    <p id="category-info"></p>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        showAllShoppingList();

        /*
            filter category
        */
        $(document).ready(function() {
            $('#catFilter').on('change', function() {
                var value = $(this).val();
                // alert(value);
                $('#lists-table-body tr').filter(function() {
                    $(this).toggle($(this).text().toLocaleLowerCase().indexOf(value) > -1)
                })
            })
        })

        /*
            filter status
        */
        $(document).ready(function() {
            $('#catStatus').on('change', function() {
                var value = $(this).val();
                // alert(value);
                $('#lists-table-body tr').filter(function() {
                    $(this).toggle($(this).text().toLocaleLowerCase().indexOf(value) > -1)
                })
            })
        })

        /*
            shows all records
        */
        function showAllShoppingList() {
            let url = $('meta[name=app-url]').attr("content") + "index.php/shoppingList/show_all";
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $("#lists-table-body").html("");
                    $("#category_id").html("");
                    let data = JSON.parse(response);
                    let shoppingLists = data['shoppingLists'];
                    let category_lists = data['category_lists'];
                    let category = data['category'];
                    // console.log(data);
                    let category_list = '';
                    for (let k = 0; k < category.length; k++) {
                        let addSelect = `<option value="` + category[k].id + `">` + category[k].title + `</option>`
                        $("#category_id").append(addSelect);
                    }

                    for (let j = 0; j < category.length; j++) {
                        let addCategoryFilter = `<option value="` + category[j].title + `">` + category[j].title + `</option>`
                        $("#catFilter").append(addCategoryFilter);
                    }


                    for (var i = 0; i < shoppingLists.length; i++) {
                        // console.log(shoppingLists[i].id);
                        for (let index = 0; index < category_lists.length; index++) {
                            if (shoppingLists[i].id == category_lists[index].list_id) {
                                category_list = category_lists[index].cat_title;
                            }
                        }
                        let showBtn = '<button ' +
                            ' class="btn btn-outline-info" ' +
                            ' onclick="showShoppingList(' + shoppingLists[i].id + ')">Show' +
                            '</button> ';
                        let editBtn = '<button ' +
                            ' class="btn btn-outline-success" ' +
                            ' onclick="editShoppingList(' + shoppingLists[i].id + ')">Edit' +
                            '</button> ';
                        let deleteBtn = '<button ' +
                            ' class="btn btn-outline-danger" ' +
                            ' onclick="destroyShoppingList(' + shoppingLists[i].id + ')">Delete' +
                            '</button>';

                        let statusWord = shoppingLists[i].status == 1 ? 'bought' : 'unfinished';

                        let shoppingListRow = '<tr>' +
                            '<td>' + shoppingLists[i].title + '</td>' +
                            '<td>' + shoppingLists[i].date_added + '</td>' +
                            '<td onclick="editShoppingList(' + shoppingLists[i].id + ')">' + statusWord + '</td>' +
                            '<td>' + category_list + '</td>' +
                            '<td>' + showBtn + editBtn + deleteBtn + '</td>' +
                            '</tr>';
                        $("#lists-table-body").append(shoppingListRow);


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
        $("#save-shoppinglist-btn").click(function(event) {
            event.preventDefault();
            if ($("#update_id").val() == null || $("#update_id").val() == "") {
                storeShoppingList();
            } else {
                updateShoppingList();
            }
        })

        /*
            show modal for creating a record and 
            empty the values of form and remove existing alerts
        */
        function createShoppingList() {
            $("#alert-div").html("");
            $("#modal-alert-div").html("");
            $("#update_id").val("");
            $("#title").val("");
            $("#status").val("");
            $("#category_id").val("");
            $("#form-modal").modal('show');
        }

        /*
            submit the form and will be stored to the database
        */
        function storeShoppingList() {
            $("#save-shoppinglist-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "index.php/shoppingList/store";
            let data = {
                title: $("#title").val(),
                status: $("#status").val(),
                category_id: $("#category_id").val(),
            };
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function(response) {
                    $("#save-shoppinglist-btn").prop('disabled', false);
                    let successHtml = '<div class="alert alert-success" role="alert"><b>ShoppingList Created Successfully</b></div>';
                    $("#alert-div").html(successHtml);
                    $("#title").val("");
                    $("#status").val("");
                    $("#category_id").val("");
                    showAllShoppingList();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    $("#save-shoppinglist-btn").prop('disabled', false);

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
            it will get the existing value and show the list form
        */
        function editShoppingList(id) {
            let url = $('meta[name=app-url]').attr("content") + "index.php/shoppingList/edit/" + id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    let shoppingList = response;
                    $("#alert-div").html("");
                    $("#modal-alert-div").html("");
                    $("#update_id").val(shoppingList.id);
                    $("#title").val(shoppingList.title);
                    $("#status").val(shoppingList.status);
                    $("#category_id").val(shoppingList.category_id);
                    $("#form-modal").modal('show');
                },
                error: function(response) {

                }
            });
        }
       
        // function editStatus(id) {
        //     let url = $('meta[name=app-url]').attr("content") + "index.php/shoppingList/edit/" + id;
        //     $.ajax({
        //         url: url,
        //         type: "GET",
        //         success: function(response) {
        //             let shoppingList = response;
        //             $("#alert-div").html("");
        //             $("#modal-alert-div").html("");
        //             $("#update_id").val(shoppingList.id);
        //             $("#status").val(shoppingList.status);
        //             $("#form-status").modal('show');
        //         },
        //         error: function(response) {

        //         }
        //     });
        // }

        /*
            sumbit the form and will update a record
        */
        function updateShoppingList() {
            $("#save-shoppinglist-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "index.php/shoppingList/update/" + $("#update_id").val();
            let data = {
                id: $("#update_id").val(),
                title: $("#title").val(),
                date_added: $("#date_added").val(),
                status: $("#status").val(),
                category_id: $("#category_id").val(),
            };
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function(response) {
                    $("#save-shoppinglist-btn").prop('disabled', false);
                    let successHtml = '<div class="alert alert-success" role="alert"><b>Shopping List Updated Successfully</b></div>';
                    $("#alert-div").html(successHtml);
                    $("#name").val("");
                    $("#description").val("");
                    showAllShoppingList();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    /*
                        show validation error
                    */
                    $("#save-shoppinglist-btn").prop('disabled', false);

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
       
        function showShoppingList(id) {
            $("#title-info").html("");
            $("#date-info").html("");
            $("#status-info").html("");
            $("#category-info").html("");
            let url = $('meta[name=app-url]').attr("content") + "index.php/shoppingList/show/" + id + "";
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    // console.log(response);
                    let shoppingList = response;
                    let statusWord = shoppingList.status == 1 ? 'bought' : 'unfinished';
                    $("#title-info").html(shoppingList.title);
                    $("#date-info").html(shoppingList.date_added);
                    $("#status-info").html(statusWord);
                    $("#category-info").html(shoppingList.category_id);
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

        function destroyShoppingList(id) {
            let url = $('meta[name=app-url]').attr("content") + "index.php/shoppingList/delete/" + id;
            let data = {
                title: $("#title").val(),
                date_added: $("#date_added").val(),
                status: $("#status").val(),
                category: $("#category_id").val()
            };
            $.ajax({
                url: url,
                type: "DELETE",
                data: data,
                success: function(response) {
                    let successHtml = '<div class="alert alert-success" role="alert"><b>Project Deleted Successfully</b></div>';
                    $("#alert-div").html(successHtml);
                    showAllShoppingList();
                },
                error: function(response) {
                    console.log(response)
                }
            });
        }
    </script>
</body>

</html>