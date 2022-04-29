<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    document.getElementById("logs-btn").classList.add("active")
</script>

<?php
include("../server/db_connection.php");

$sql = "SELECT tbl_usr.Firstname, tbl_usr.Lastname, tbl_usr.Picture, tbl_activitylog.ID, tbl_activitylog.TimeStamp, tbl_activitylog.Description, tbl_activitylog.Status FROM tbl_usr, tbl_activitylog WHERE tbl_activitylog.Username = tbl_usr.UserID  ORDER BY tbl_activitylog.ID DESC";
$result = mysqli_query($conn, $sql);
?>

<script>
    $(document).ready(function(){
        $("#dropDownFilter").change(function(){
            var txt = $(this).val();
            $.ajax({
                method: 'post',
                url: '../templates/logs/search.php',
                data: {search: txt},
                datatype: "text",
                success: function(data){
                    $("#data").html(data);
                }
            });
        });

        $("#txtdate").change(function(){
            var txt = $(this).val();
            $.ajax({
                method: 'post',
                url: '../templates/logs/search.php',
                data: {search: txt},
                datatype: "text",
                success: function(data){
                    $("#data").html(data);
                }
            });
        });
    });

    function refresh(){
        var txt = $("#dropDownFilter").val();
        $.ajax({
            method: 'post',
            url: '../templates/logs/search.php',
            data: {search: txt},
            datatype: "text",
             success: function(data){
                $("#data").html(data);
            }
        });
    }

    function clearLog(){
        if(confirm("Are you sure you want to clear activity logs? \n Note: This action cannot be undone.")){
            $.ajax({
                method: 'post',
                url: '../server/action.php',
                data: {
                    action: "clear-logs"
                },
                datatype: "text",
                success: function(data){
                    window.location.href = "../admin/homepage.php?page=logs";
                }
            });
        }
    }
</script>

<div class="container">
    <h3 style="color: dodgerblue">Activity Logs</h3>

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <ul class="nav text-secondary">
                    <li class="nav-item">
                        <select id="dropDownFilter" class="form-select">
                            <option value="all">All</option>
                            <option value="today">Today</option>
                            <option value="this-month">This Month</option>
                        </select>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" data-toggle="tooltip" title="refresh" onclick="refresh()">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#arrow-rotate-right"/></svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" data-toggle="tooltip" title="Clear Logs" onclick="clearLog()">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#trash"/></svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <form class="d-flex">
                    <input class="form-control me-2" id="txtdate" type="date" placeholder="Search" aria-label="Search" >
                </form>
            </div>
        </div>
      <hr class="dropdown-divider">
      <div id="data" class="container">
        <ul class="list-group">
            <?php
            while($row = mysqli_fetch_array($result))
            {
                ?>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-1 align-self-center">
                            <img src="../img/user.png" width="42px" height="42px">
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <b><?php echo $row["Firstname"] . " " . $row["Lastname"]; ?></b>
                                </div>
                                <div class="col">
                                    <small>
                                        <p class="text-end"><?php echo $row["TimeStamp"]; ?></p>
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                <?php echo $row["Description"]; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
            }

            if(mysqli_num_rows($result) == 0)
            {
                ?>
                <ul class="list-group">
                    <li class="list-group-item align-self-center">
                        No Activities
                    </li>
                </ul>
                <?php
            }
            ?>
        </ul>
      </div>
    </div>
</div>

<style>
    .container{
        margin: 20px 10px;
    }
    #data {
        position: relative;
        width: 100%;
        height: 450px;
        overflow: auto;
        display: block;
    }
</style>