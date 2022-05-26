<?php
    include("../../server/db_connection.php");
    $pid = $_POST["productId"];

    $sql = "SELECT * FROM tbl_medications WHERE Product_ID = '$pid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <form action="../server/action.php?id=<?php echo $pid; ?>" method="POST">
    <form method="POST" action="../server/action.php?id=<?php echo $pid; ?>">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Medication</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="con-medication" class="content">
                <br>
                <div class="row">
                    <div class="col">
                        <small>Brand Name<span class="text-danger"> *</span></small>
                        <input type="text" name="brand" class="form-control" value="<?php echo $row["Brand"]; ?>">   
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <small>Product Name<span class="text-danger"> *</span></small>
                        <input type="text" name="name" class="form-control" value="<?php echo $row["Name"]; ?>">   
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <small>Dosage<span class="text-danger"> *</span></small>
                        <input type="text" name="dosage" class="form-control" value="<?php echo $row["Unit"]; ?>">   
                    </div>
                    <div class="col">
                        <small>Price<span class="text-danger"> *</span></small>
                        <input type="number" name="price" class="form-control" value="<?php echo $row["Price"]; ?>">   
                    </div>
                    <div class="col">
                        <small>Par Stock Level<span class="text-danger" min="1"> *</span></small>
                        <input type="number" name="psl" class="form-control" min="1" value="<?php echo $row["Par_Stock_Level"]; ?>">   
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="submit-btn" name="editMedication" type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>