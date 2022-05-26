    <?php
    include("../../server/db_connection.php");
    $pid = $_POST["productId"];

    $sql = "SELECT * FROM tbl_supplies WHERE Product_ID = '$pid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <form action="../server/action.php?id=<?php echo $pid; ?>" method="POST">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Supplies</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
        <div class="modal-body">
            <small>Item Category<span class="text-danger"> *</span></small>
            <script>
                document.getElementById("dropCategory").value = '<?php echo $row["Category"]; ?>';
            </script>
            <select id="dropCategory" class="form-select" name="supply-category" required>
                    <option>---</option>
                    <option>Diagnostic Instruments/Accessories</option>
                    <option>Sterilization Instruments/Accessories</option>
                    <option>Surgery Instruments/Accessories</option>
                    <option>Prosthodontic Instruments/Accessories</option>
                     <option>Orthodontic Instruments</option>
                    <option>Endodontic Materials</option>
            </select>
            <small>Product Name<span class="text-danger"> *</span></small>
            <textarea class="form-control" name="supply-name" autocomplete="off" required><?php echo $row["Product_Name"]; ?></textarea>
            <div class="row">
                <div class="col">
                    <small>Stocks<span class="text-danger"> *</span></small>
                    <input type="number" class="form-control" name="stocks" min="1" value="<?php echo $row["Stocks"]; ?>" required>
                </div>
                <div class="col">
                    <small>Par Stock Level<span class="text-danger"> *</span></small>
                    <input type="number" class="form-control" name="psl" min="1" value="<?php echo $row["Par_Stock_Level"]; ?>" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
            <button type="submit" name="edit-supply" class="btn btn-primary">Save Changes</button>
        </div>
    </form>