<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP + JQuery CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class="pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md">
                <h1>PHP + JQuery CRUD</h1>
                <button class="btn btn-primary float-right mb-3 add" data-toggle="modal" data-target="#userModal">Add</button>
                <div id="users" class="table-responsive"></div>

                <!-- Modal -->
                <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                    <form id="userForm" action="" method="post">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userModalLabel"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="first_name" id="first_name" placeholder="First Name">
                                        <span id="error_first_name" class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Last Name">
                                        <span id="error_last_name" class="text-danger"></span>
                                    </div>
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="action" id="action">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            load();

            function load() {
                $.ajax({
                    url: 'fetch.php',
                    method: 'POST',
                    success: function(data) {
                        $('#users').html(data);
                    }
                });
            }

            $('.add').on('click', function() {
                $('#userModalLabel').html('Add Data');
                $('.modal-footer button[type=submit]').html('Insert');
                $('#id').val('');
                $('#first_name').val('');
                $('#last_name').val('');
                $('#action').val('insert');
            });

            $('#userForm').on('submit', function(event) {
                event.preventDefault();
                const first_name = $('#first_name').val();
                const last_name = $('#last_name').val();

                var firstName = '';
                var lastName = '';

                if (first_name == '') {
                    firstName = 'First Name is required';
                } else {
                    firstName = '';
                }
                $('#error_first_name').html(firstName);

                if (last_name == '') {
                    lastName = 'Last Name is required';
                } else {
                    lastName = '';
                }
                $('#error_last_name').html(lastName);

                if (first_name == '' || last_name == '') {
                    return false;
                } else {
                    var form_data = $(this).serialize();
                    $.ajax({
                        url: 'action.php',
                        method: 'POST',
                        data: form_data,
                        success: function(data) {
                            $("#userModal .close").click();
                            load();
                        }
                    });
                }
            });

            $(document).on('click', '.delete', function() {
                var conf = confirm("Are you sure?");
                if (conf == true) {
                    const id = $(this).data('id');
                    $.ajax({
                        url: 'action.php',
                        method: 'POST',
                        data: {
                            id: id,
                            action: 'delete'
                        },
                        success: function(data) {
                            load();
                        }
                    });
                } else {
                    return false;
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const id = $(this).data('id');
            $('#userModalLabel').html('Update Data');
            $('.modal-footer button[type=submit]').html('Update');
            $.ajax({
                url: 'action.php',
                data: {
                    id: id,
                    action: 'user'
                },
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    $('#id').val(response.id);
                    $('#first_name').val(response.first_name);
                    $('#last_name').val(response.last_name);
                    $('#action').val('update');
                }
            });
        });
    </script>
</body>

</html>