$(document).ready(function () {
  insertUser();
  display();
  showEditUser();
  editUser();
  deleteUser();
  searchUser();
  delimage();
});

//Insert user --------------------------
function insertUser() {
  $(document).on("click", "#btn_submit_add", function () {
    var users = [
      {
        userName: $("#UserName").val(),
        userAddress: $("#UserAddress").val(),
        userBirthday: $("#userDateOfBirth").val(),
        userStore: $("#store").val(),
        userGroup: $("#group").val(),
      },
    ];
    if (
      users[0].userName == "" ||
      users[0].userAddress == "" ||
      users[0].userBirthday == ""
    ) {
      $("#message").html("Chưa nhập thông tin!");
    } else {
      $.ajax({
        url: "insertUser.php",
        method: "post",
        data: { users },
        success: function (data) {
          $("#message").html(data);
          $("form").trigger("reset");
          display();
        },
      });
    }
  });

  const myModalEl = document.getElementById("add_user");
  myModalEl.addEventListener("hidden.bs.modal", () => {
    $("form").trigger("reset");
  });
}

//Show user --------------------------

function display(page = 1) {
  $.ajax({
    url: "view.php",
    method: "get",
    data: { page },
    success: function (data) {
      data = JSON.parse(data);
      if (data.status == "success") {
        // $("#table").html(data.html);
        $("#pagination").html(data.pagination);
        $("#preview").html("");
        showDisplay(data.result);
      }
    },
  });
}
// showwwww userrrr
function showDisplay(result) {
  var value;
  for (let index = 0; index < result.length; index++) {
    value += `<tr>
    <td scope="row">${result[index].id}</td>
    <td>${result[index].name}</td>
    <td>${result[index].address}</td>
    <td>${result[index].birthday}</td>
    <td>${result[index].strname}</td>
    <td>${result[index].description}</td>
    <td>${result[index].created}</td>
    <td><button class="btn btn-group" id="btn_edit" data-id="${result[index].id}"><i class="fa-solid fa-pen-to-square" style="color:blue;"></i></button>
    <button class="btn btn-group" id="btn_remove"  data-id="${result[index].id}"><i class="fa-solid fa-trash" style="color:red;"></i></button></td>
    </tr>`;
  }  
  $('#table').html(value);
}
//Edit user --------------------------

function showEditUser() {
  $(document).on("click", "#btn_edit", function () {
    var ID = $(this).attr("data-id");
    $("#edit_user").modal("show");
    $.ajax({
      url: "showEditUser.php",
      method: "post",
      data: { userID: ID },
      dataType: "JSON",
      success: function (data) {
        $("#Edit_UserName").val(data["data"]["name"]);
        $("#Edit_UserAddress").val(data["data"]["address"]);
        $("#Edit_userDateOfBirth").val(data["data"]["birthday"]);
        $("#idEdit").val(data["data"]["userID"]);
        $("#showImage").html(data["img"]);
        $("#Edit_store").val(data["data"]["storeID"]).change();
        $("#Edit_group").val(data["data"]["groupID"]).change();
      },
    });
  });
  const myModalEl = document.getElementById("edit_user");
  myModalEl.addEventListener("hidden.bs.modal", () => {
    $("form").trigger("reset");
  });
}
function editUser() {
  $(document).on("click", "#btn_submit_edit", function (e) {
    e.preventDefault();
    var form_data = new FormData();
    var lenObjImg = $("#image")[0].files.length;

    // console.log(lenObjImg);
    // console.log($('#image')[0].files);
    // var userImg = [];
    for (let index = 0; index < lenObjImg; index++) {
      // form_data.set("my_img_" + index, $("#image")[0].files[index]);
      form_data.append("my_img[]", $("#image")[0].files[index]);
    }

    form_data.append("lenObjImg", lenObjImg);
    form_data.append("editId", $("#idEdit").val());
    form_data.append("nameId", $("#Edit_UserName").val());
    form_data.append("addressId", $("#Edit_UserAddress").val());
    form_data.append("birthId", $("#Edit_userDateOfBirth").val());
    form_data.append("storeId", $("#Edit_store").val());
    form_data.append("groupId", $("#Edit_group").val());
    $.ajax({
      url: "editUser.php",
      method: "post",
      data: form_data,
      contentType: false,
      processData: false,
      success: function (data) {
        $("#message").html(data);
        // showEditUser();
        $("#edit_user").modal("hide");
        display();
      },
    });
  });
}
function deleteUser() {
  $(document).on("click", "#btn_remove", function () {
    var ID = $(this).attr("data-id");
    $("#deleteUser").modal("show");
    $(document).on("click", "#btn_submit_delete", function () {
      $.ajax({
        url: "deleteUser.php",
        method: "post",
        data: { userID: ID },
        success: function (data) {
          $("#message").html(data);
          display();
          $("#deleteUser").modal("hide");
        },
      });
    });
  });
}
function searchUser() {
  $(document).on("click", "#submitSearch", function () {
    var storeSearch = $("#searchStore").val();
    var groupSearch = $("#searchGroup").val();
    $.ajax({
      url: "searchUser.php",
      method: "post",
      data: { storeS: storeSearch, groupS: groupSearch },
      success: function (res) {
        res = JSON.parse(res);
        if (res.status == "success") {
          $("#table").html(res.html);
          $("#pagination").html("");
        }
      },
    });
  });
}
function delimage() {
  $(document).on("click", "#deleteIMG", function (e) {
    e.preventDefault();
    var IdDel = $(this).attr("data-id");
    $.ajax({
      url: "deleteIMG.php",
      method: "post",
      data: { imgID: IdDel },
      success: function () {
        $("#edit_user").modal("hide");
        // var tdremove = $('#td_img_id').attr('data-id');
        // if (tdremove == IdDel) {
        //     $('#td_img_id').remove();
        // }
        display();
        Swal.fire("Xoá Thành Công!", "", "success");
      },
    });
  });
}
