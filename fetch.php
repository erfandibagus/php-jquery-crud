<?php

include("config.php");

$query = "SELECT * FROM users ORDER BY id DESC";
$statement = $connect->prepare($query);
$statement->execute();
$results = $statement->fetchAll();
$total_rows = $statement->rowCount();

$output = '
<table class="table table-hovered">
    <thead>
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
';
$i = 1;
foreach ($results as $result) {
    $output .= '
        <tr>
            <td>' . $i++ . '</td>
            <td>' . $result['first_name'] . '</td>
            <td>' . $result['last_name'] . '</td>
            <td>
                <button class="btn btn-success btn-sm mr-1 edit" data-toggle="modal" data-target="#userModal" data-id="' . $result['id'] . '">Edit</button>
                <button href="#" class="btn btn-danger btn-sm mr-1 delete" data-id="' . $result['id'] . '">Delete</button>
            </td>
        </tr>
    ';
}
$output .= '
    </tbody>
</table>
';

echo $output;
