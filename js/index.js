$(document).ready(function () {
  insertUser();
  display();
  showEditUser();
  editUser();
  deleteUser();
  searchUser();
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
        userImg: $('#image')[0].files
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
    data : {page},
    success: function (data) {
      data = JSON.parse(data);
      if (data.status == "success") {
        $("#table").html(data.html);
        $("#pagination").html(data.pagination);
      }
    },
  });
}

//Edit user --------------------------

function showEditUser() {
  $(document).on("click", "#btn_edit", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "showEditUser.php",
      method: "post",
      data: { userID: ID },
      dataType: "JSON",
      success: function (data) {
        $("#Edit_UserName").val(data[0]);
        $("#Edit_UserAddress").val(data[1]);
        $("#Edit_userDateOfBirth").val(data[2]);
        $("#idEdit").val(data[5]);
      },
    });
  });
}
function editUser() {
  $(document).on("click", "#btn_submit_edit", function () {
    var editId = $("#idEdit").val();
    var nameId = $("#Edit_UserName").val();
    var addressId = $("#Edit_UserAddress").val();
    var birthId = $("#Edit_userDateOfBirth").val();
    var storeId = $("#Edit_store").val();
    var groupId = $("#Edit_group").val();
    $.ajax({
      url: "editUser.php",
      method: "post",
      data: {
        eid: editId,
        nid: nameId,
        aid: addressId,
        bid: birthId,
        sid: storeId,
        gid: groupId,
      },
      success: function (data) {
        $("#message").html(data);
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
        }
      },
    });
  });
}
