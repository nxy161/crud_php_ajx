<?php

require_once('connect.php');
//insert user ---------------------------
function insertUser()
{
    global $conn;
    $userName = $_POST['users'][0]['userName'];
    $userAddress = $_POST['users'][0]['userAddress'];
    $userBirthday = $_POST['users'][0]['userBirthday'];
    $userStore = $_POST['users'][0]['userStore'];
    $userGroup = $_POST['users'][0]['userGroup'];
    // $userImg = $_POST['users'][0]['userImg'];
    die(print_r($_FILES));
    $formatuserDate = date('Y-m-d', strtotime($userBirthday));
    $queryInsertUser = "insert into users (name,birthday,address,main_group_id,main_store_id) 
     values('$userName','$formatuserDate','$userAddress','$userGroup','$userStore')";
    $result = mysqli_query($conn, $queryInsertUser);
    if ($result) {
        echo "<script>alert('Thêm thành công!')</script>";
    } else {
        echo "Error: " . $queryInsertUser . "<br>" . mysqli_error($conn);
    }
};
//view user ---------------------------
function showUser()
{
    global $conn;

    $value = '<thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Ngày sinh</th>
                            <th scope="col">Chi nhánh</th>
                            <th scope="col">Phòng ban</th>
                            <th scope="col">Thơi gian tạo</th>
                            <th scope="col">Chức năng</th>
                        </tr>
                </thead>
                <tbody>';
    $queryShowALl = "  SELECT us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created 
                    FROM users AS us 
                    LEFT JOIN groups as gr 
                    ON us.main_group_id = gr.id
                    LEFT JOIN stores as st
                    ON us.main_store_id  = st.id
                    ";
    $result1 = mysqli_query($conn, $queryShowALl);
    $numCol = mysqli_num_rows($result1);
    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $queryShow = "  SELECT us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created 
    FROM users AS us 
    LEFT JOIN groups as gr 
    ON us.main_group_id = gr.id
    LEFT JOIN stores as st
    ON us.main_store_id  = st.id
    Limit $limit offset $offset";
    $result = mysqli_query($conn, $queryShow);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= ' <tr>
                        <th scope="row"> ' . $row['id'] . ' </th>
                        <td >' . $row['name'] . '</td>
                        <td >' . $row['address'] . '</td>
                        <td>' . date('\N\g\à\y\ d \-\ m \-\ Y', strtotime($row['birthday'])) . '</td>
                        <td >' . ($row['strname'] == null ? '----' : $row['strname']) . '</td>
                        <td >' . ($row['description'] == null ? '----' : $row['description']) . '</td> 
                        <<td>' . date('\N\g\à\y\ d \-\ m \-\ Y \L\ú\c\ H:i:s', strtotime($row['created'])) . '</td>
                        <td>
                        <button class="btn btn-group" id="btn_edit" data-bs-toggle="modal" data-bs-target="#edit_user" data-id="' . $row['id'] . '"><i class="fa-solid fa-pen-to-square" style="color:blue;"></i></button>
                        <button class="btn btn-group" id="btn_remove"  data-id="' . $row['id'] . '"><i class="fa-solid fa-trash" style="color:red;"></i></button></td>
                       </tr>';
    }
    $value .= '</tbody>';
    $pagination  = '
                <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">';

    if ($page > 1) {
        $pagination .= '<li class="page-item ">
                    <a href="javascript:void(0)" onclick="display(' . $page - 1 . ')" class="page-link">Previous</a></li>';
    }
    for ($i = 1; $i <= ceil($numCol / 10); $i++) {
        $pagination  .= '<li class="page-item" id="' . $i . '"><a href="javascript:void(0)" onclick="display(' . $i . ')" class="page-link">' . $i . '</a></li>';
    }
    if ($page < $numCol) {
        $pagination  .= '<li class="page-item">
        <a class="page-link" href="javascript:void(0)" onclick="display(' . $page + 1 . ')"">Next</a>
        </li>';
    }

    $pagination .= '</ul>
                </nav>
                ';
    echo json_encode(['status' => 'success', 'html' => $value, 'pagination' => $pagination]);
}
//<button class="btn btn-group" id="btn_view" data-id="' . $row['id'] . '"><i class="fa-solid fa-eye" style="color:blue;"></i></button>

//edit user ---------------------------

function showEidtUser()
{
    global $conn;
    $userID = $_POST['userID'];
    $queryShowEditUser = "  SELECT us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created 
                        FROM users AS us 
                        LEFT JOIN groups as gr 
                        ON us.main_group_id = gr.id
                        LEFT JOIN stores as st
                        ON us.main_store_id  = st.id
                        where us.id = '$userID'";

    $result = mysqli_query($conn, $queryShowEditUser);
    while ($row = mysqli_fetch_assoc($result)) {
        $userUpdate[0] = $row['name'];
        $userUpdate[1] = $row['address'];
        $userUpdate[2] = $row['birthday'];
        $userUpdate[3] = $row['strname'];
        $userUpdate[4] = $row['description'];
        $userUpdate[5] = $row['id'];
    }
    echo json_encode($userUpdate);
}
function editUser()
{
    global $conn;
    $editID = $_POST['eid'];
    $editName = $_POST['nid'];
    $editAddress = $_POST['aid'];
    $tamBirth = $_POST['bid'];
    $editBirth = date('Y-m-d', strtotime($tamBirth));
    $editStore = $_POST['sid'];
    $editGroup = $_POST['gid'];
    $queryEditUser = "  update users
                        set name='$editName', address='$editAddress', birthday = '$editBirth',
                        main_group_id='$editGroup',main_store_id='$editStore' 
                        where id = '$editID'";
    $result = mysqli_query($conn, $queryEditUser);
    if ($result) {
        echo "<script>alert('Sửa thành công!')</script>";
    } else {
        echo "Error: " . $queryEditUser . "<br>" . mysqli_error($conn);
    }
}
function deleteUser()
{
    global $conn;
    $deleteID = $_POST['userID'];
    $queryDelete = "delete from users where id = $deleteID";
    $result = mysqli_query($conn, $queryDelete);
    if ($result) {
        echo "<script>alert('Xóa thành công!')</script>";
    } else {
        echo "Error: " . $queryDelete . "<br>" . mysqli_error($conn);
    }
}
function searchUser()
{
    global $conn;
    $value = '<thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Ngày sinh</th>
                            <th scope="col">Chi nhánh</th>
                            <th scope="col">Phòng ban</th>
                            <th scope="col">Thơi gian tạo</th>
                            <th scope="col">Chức năng</th>
                        </tr>
                </thead>
                <tbody>';
    $searchStore = $_POST['storeS'];
    $searchGroup = $_POST['groupS'];
    $querySearchShow = "SELECT us.id, 
    us.name, us.address, us.birthday, st.name as strname, gr.description, us.created FROM users AS us 
    LEFT JOIN groups as gr 
    ON us.main_group_id = gr.id
    LEFT JOIN stores as st
    ON us.main_store_id  = st.id";
    if ($searchStore == 'all' && $searchGroup == 'all') {
        $querySearchShow;
    } else if ($searchStore == 'all') {
        $querySearch = "  SELECT st.id, gr.id, us.id, 
        us.name, us.address, us.birthday, st.name as strname, gr.description, us.created 
        FROM users AS us 
        LEFT JOIN groups as gr 
        ON us.main_group_id = gr.id
        LEFT JOIN stores as st
        ON us.main_store_id  = st.id
        Where gr.id = '$searchGroup'";
        $querySearchShow = $querySearch;
    } else if ($searchGroup == 'all') {
        $querySearch = "  SELECT st.id, gr.id, us.id, 
        us.name, us.address, us.birthday, st.name as strname, gr.description, us.created 
        FROM users AS us 
        LEFT JOIN groups as gr 
        ON us.main_group_id = gr.id
        LEFT JOIN stores as st
        ON us.main_store_id  = st.id
        Where st.id = '$searchStore'";
        $querySearchShow = $querySearch;
    } else {
        $querySearch = "  SELECT st.id, gr.id, us.id, 
        us.name, us.address, us.birthday, st.name as strname, gr.description, us.created 
        FROM users AS us 
        LEFT JOIN groups as gr 
        ON us.main_group_id = gr.id
        LEFT JOIN stores as st
        ON us.main_store_id  = st.id
        Where st.id = '$searchStore' and gr.id = '$searchGroup'";
        $querySearchShow = $querySearch;
    }
    $result = mysqli_query($conn, $querySearchShow);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= ' <tr>
                        <th scope="row"> ' . $row['id'] . ' </th>
                        <td >' . $row['name'] . '</td>
                        <td >' . $row['address'] . '</td>
                        <td>' . date('\N\g\à\y\ d \-\ m \-\ Y', strtotime($row['birthday'])) . '</td>
                        <td >' . ($row['strname'] == null ? '----' : $row['strname']) . '</td>
                        <td >' . ($row['description'] == null ? '----' : $row['description']) . '</td> 
                        <<td>' . date('\N\g\à\y\ d \-\ m \-\ Y \L\ú\c\ H:i:s', strtotime($row['created'])) . '</td>
                        <td>
                        <button class="btn btn-group" id="btn_edit" data-bs-toggle="modal" data-bs-target="#edit_user" data-id="' . $row['id'] . '"><i class="fa-solid fa-pen-to-square" style="color:blue;"></i></button>
                        <button class="btn btn-group" id="btn_remove"  data-id="' . $row['id'] . '"><i class="fa-solid fa-trash" style="color:red;"></i></button></td>
                       </tr>';
    }
    $value .= '</tbody>';

    echo json_encode(['status' => 'success', 'html' => $value]);
}
