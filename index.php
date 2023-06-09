<?php
include './include/connect.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome-free-6.3.0-web/css/all.min.css">
=======
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/fontawesome-free-6.3.0-web/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
>>>>>>> 785b264d122614d3c53404513982a9a065373d4a
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <title>Document</title>
</head>

<body>
    <p id="message-delete"></p>
    <div style="margin-left: 50px;">

        <h1>Danh sách nhân viên</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_user">
            Thêm Nhân Viên
        </button>
    </div>


    <!-- Modal Add User -->
    <form method="post" enctype="multipart/form-data">
        <div class="modal fade" id="add_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Nhân Viên</h1>
                        <button type="button" class="btn-close btn_close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="message" class="text-danger"></p>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Tên nhân viên</span>
                            <input id="UserName" name="nameuser" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Địa chỉ</span>
                            <input id="UserAddress" name="address" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Ngày sinh</span>
                            <input id="userDateOfBirth" autocomplete="off" type="text" name="birthday" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Chi nhánh</span>
                            <?php
                            $querySelectStore = mysqli_query($conn, "(SELECT name FROM stores)");
                            echo '<select id="store" name="store" class="form-select" aria-label="Default select example">';
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($querySelectStore)) {
                                echo '<option value="' . $i . '">' . $row['name'] . '</option>';
                                $i++;
                            }
                            echo '</select>';
                            ?>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Phòng ban</span>
                            <?php
                            $querySelectGroup = mysqli_query($conn, "(SELECT description FROM groups)");
                            echo '<select id="group" name="group" class="form-select" aria-label="Default select example">';
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($querySelectGroup)) {
                                echo '<option value="' . $i . '">' . $row['description'] . '</option>';
                                $i++;
                            }
                            echo '</select>';
                            ?>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn_close" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" name="submit" id="btn_submit_add">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- End Modal Add User -->



    <!-- Modal Edit User -->
    <form method="post" enctype="multipart/form-data">
        <div class="modal fade" id="edit_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Chỉnh Sửa Nhân Viên</h1>
                        <button type="button" class="btn-close btn_close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="edit_message" class="text-danger"></p>
                        <input type="hidden" id="idEdit" value="">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Tên nhân viên</span>
                            <input id="Edit_UserName" name="nameuser" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Địa chỉ</span>
                            <input id="Edit_UserAddress" name="address" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Ngày sinh</span>
                            <input id="Edit_userDateOfBirth" autocomplete="off" type="text" name="birthday" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Chi nhánh</span>
                            <select id="Edit_store" name="store" value="" class="form-select" aria-label="Default select example">
                                <?php
                                
                                $querySelectStore = mysqli_query($conn, "(SELECT name FROM stores)");
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($querySelectStore)) {
                                    // if ($row['name']) {
                                    // echo '<option selected value="' . $i . '">' . $row['name'] . '</option>';
                                    // } else {
                                    echo '<option  value="' .$i . '">' . $row['name'] . '</option>';
                                    // }

                                    $i++;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Phòng ban</span>
                            <select id="Edit_group" name="group" class="form-select" aria-label="Default select example">
                                <?php
                                $querySelectGroup = mysqli_query($conn, "(SELECT description FROM groups)");
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($querySelectGroup)) {
                                    echo '<option  value="' . $i . '">' . $row['description'] . '</option>';
                                    $i++;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <input autocomplete="off" onchange="previewIMG(event)" id="image" type="file" multiple name="img[]" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span style="margin-right: 20px;">Hình ảnh</span>
                            <div id="showImage">

                            </div>
                        </div>
                        <div id="preview">
                            <div style="display: none;" id="remove_img_upload"><i class="fas fa fa-times"></i></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn_close" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" name="submit" id="btn_submit_edit">Chỉnh sửa</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- End Modal Edit User -->
    <form method="post">
        <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Xác nhận xóa nhân viên?</h3>
                        <button type="button" class="btn btn-danger btn_close" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" name="submit" id="btn_submit_delete">Đồng Ý</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post">
        <div class="search d-flex">
            <div class="col-3 m-5">
                <h5>Chi nhánh</h5>
                <?php
                $querySelectStore = mysqli_query($conn, "(SELECT name FROM stores)");
                echo '<select id="searchStore" name="storeSearch" class="form-select" aria-label="Default select example">';
                echo '<option selected value="all">Tất cả</option>';
                $i = 1;
                while ($row = mysqli_fetch_assoc($querySelectStore)) {
                    echo '<option value="' . $i . '">' . $row['name'] . '</option>';
                    $i++;
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-3 m-5">
                <h5>Phòng ban</h5>
                <?php
                $querySelectGroup = mysqli_query($conn, "(SELECT description FROM groups)");
                echo '<select id="searchGroup" name="groupSearch" class="form-select" aria-label="Default select example">';
                echo '<option selected value="all">Tất cả</option>';
                $i = 1;
                while ($row = mysqli_fetch_assoc($querySelectGroup)) {
                    echo '<option value="' . $i . '">' . $row['description'] . '</option>';
                    $i++;
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-3 m-5" style="margin-top: 5rem!important;">
                <button type="button" id="submitSearch" name="submitSearch" class="btn btn-primary">Tìm Kiếm</button>
            </div>
        </div>
    </form>
    <div class="table m-3">
        <table  class="table">
            <thead>
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
            <tbody id="table">

            </tbody>
        </table>
        <div id="pagination"></div>
    </div>






    <link rel="stylesheet" href="./css/jquery.datetimepicker.css">
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery.datetimepicker.js"></script>
    <script src="./js/jquery.js"></script>
    <script src="./js/jquery1.js"></script>
    <script src="./js/index.js"></script>
    <script src="./js/jquery.datetimepicker.full.min.js"></script>
    <script>
        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')
        jQuery('#userDateOfBirth').datetimepicker();
        jQuery.datetimepicker.setLocale('de');
        jQuery('#userDateOfBirth').datetimepicker({
            i18n: {
                de: {
                    months: [
                        'Januar', 'Februar', 'März', 'April',
                        'Mai', 'Juni', 'Juli', 'August',
                        'September', 'Oktober', 'November', 'Dezember',
                    ],
                    dayOfWeek: [
                        "So.", "Mo", "Di", "Mi",
                        "Do", "Fr", "Sa.",
                    ]
                }
            },
            timepicker: false,
            format: 'd.m.Y'
        });
        jQuery('#Edit_userDateOfBirth').datetimepicker();
        jQuery.datetimepicker.setLocale('de');
        jQuery('#Edit_userDateOfBirth').datetimepicker({
            i18n: {
                de: {
                    months: [
                        'Januar', 'Februar', 'März', 'April',
                        'Mai', 'Juni', 'Juli', 'August',
                        'September', 'Oktober', 'November', 'Dezember',
                    ],
                    dayOfWeek: [
                        "So.", "Mo", "Di", "Mi",
                        "Do", "Fr", "Sa.",
                    ]
                }
            },
            timepicker: false,
            format: 'd.m.Y'
        });

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()

        });

        function previewIMG(event) {
            var image = URL.createObjectURL(event.target.files[0]);
            var imageDiv = $('#preview');
            var showdiv = $('#showImage');
            var newimg = document.createElement('img');
            newimg.src = image;
            newimg.width = '50';
            newimg.height = '50';

            // var delimg = document.createElement('i');
            // delimg.class = 'fas fa fa-times';
            imageDiv.append(newimg);
            // imageDiv.append(delimg);

        }
    </script>
</body>

</html>