<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<div class="modal fade" id="manage-accounts-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Manage Accounts</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input id="txt-search" type="text" class="form-control" autocomplete="off" placeholder="Search Username...">
        <div class="container scroll">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="table-data">
                    <?php
                    include("../server/db_connection.php");
                    $sql = "SELECT * FROM tbl_usr";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_array($result))
                    {
                        if($row["UserID"] == 1)
                        {
                            echo "
                            <tr>
                                <th scope='row'>". $row["Username"] ."</th>
                                <td>". $row["Lastname"] . " " . $row["Firstname"] ."</td>
                                <td>
                                <a href='#' class='circle btn btn-success' onclick='editAccount(". $row["UserID"] .")'><i class='fa fa-pen'></i></a>
                                <a href='#' class='circle btn btn-danger disabled'><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                            ";
                        }
                        else
                        {
                            echo "
                            <tr>
                                <th scope='row'>". $row["Username"] ."</th>
                                <td>". $row["Lastname"] . " " . $row["Firstname"] ."</td>
                                <td>
                                <a href='#' class='circle btn btn-success' onclick='editAccount(". $row["UserID"] .")'><i class='fa fa-pen'></i></a>
                                <a href='#' class='circle btn btn-danger' onclick='deleteAccount(". $row["UserID"] .")'><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                            ";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-user-modal">Add Account</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-user-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="modal-content" class="modal-content">
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $("#txt-search").keyup(function(){
      var txt = $(this).val();

      $.ajax({
          method: 'post',
          url: '../templates/modals/search-account.php',
          data: {
              name: txt
          },
          datatype: "text",
          success: function(data){
            $("#table-data").html(data);
          }
      });
    });
  });

  function editAccount(id){
    $.ajax({
      method: 'post',
      url: '../templates/modals/edit-account-modal.php',
      data: {
        userId: id
      },
      datatype: "text",
      success: function(data){
        $("#modal-content").html(data);
      }
    });

    $("#edit-user-modal").modal("show");
  }

  function deleteAccount(uId) {
    if(confirm("Are you sure you want to delete this account?")) {
      $.ajax({
          method: 'post',
          url: '../server/action.php',
          data: {
              userID: uId,
              action: "deleteAccount"
          },
          datatype: "text",
          success: function(data){
            $("#table-data").html(data);
          }
      });
    }
      
  }
</script>

<style>
    .scroll {
        position: relative;
        width: auto;
        height: 300px;
        overflow: auto;
        display: block;
    }
</style>