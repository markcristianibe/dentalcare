<?php
include("../../server/db_connection.php");
if(isset($_POST["search"]))
{
    $sql;
    $search = mysqli_real_escape_string($conn, $_POST["search"]);
    if($search == "today")
    {
        $sql = "SELECT tbl_usr.Firstname, tbl_usr.Lastname, tbl_usr.Picture, tbl_activitylog.ID, tbl_activitylog.TimeStamp, tbl_activitylog.Description, tbl_activitylog.Status FROM tbl_usr, tbl_activitylog WHERE tbl_activitylog.Username = tbl_usr.UserID AND TimeStamp LIKE '". date("Y-m-d") ."%' ORDER BY tbl_activitylog.ID DESC";
    }
    else if($search == "this-month")
    {
        $sql = "SELECT tbl_usr.Firstname, tbl_usr.Lastname, tbl_usr.Picture, tbl_activitylog.ID, tbl_activitylog.TimeStamp, tbl_activitylog.Description, tbl_activitylog.Status FROM tbl_usr, tbl_activitylog WHERE tbl_activitylog.Username = tbl_usr.UserID AND TimeStamp LIKE '". date("Y-m-") ."%' ORDER BY tbl_activitylog.ID DESC";
    }
    else if($search == "all")
    {
        $sql = "SELECT tbl_usr.Firstname, tbl_usr.Lastname, tbl_usr.Picture, tbl_activitylog.ID, tbl_activitylog.TimeStamp, tbl_activitylog.Description, tbl_activitylog.Status FROM tbl_usr, tbl_activitylog WHERE tbl_activitylog.Username = tbl_usr.UserID ORDER BY tbl_activitylog.ID DESC";
    }
    else
    {
        $sql = "SELECT tbl_usr.Firstname, tbl_usr.Lastname, tbl_usr.Picture, tbl_activitylog.ID, tbl_activitylog.TimeStamp, tbl_activitylog.Description, tbl_activitylog.Status FROM tbl_usr, tbl_activitylog WHERE tbl_activitylog.Username = tbl_usr.UserID AND TimeStamp LIKE '$search%' ORDER BY tbl_activitylog.ID DESC";
    }
    $result = mysqli_query($conn, $sql);
}

?>

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
        <li class="list-group-item align-self-center">
            No Activities
        </li>
        <?php
    }
    ?>
</ul>