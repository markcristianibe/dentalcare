<?php
include("../../server/db_connection.php");

$id = $_POST["productId"];

$result = mysqli_query($conn, "SELECT * FROM tbl_supplies WHERE Product_ID = '$id'");
$row = mysqli_fetch_assoc($result);
?>

<form method="POST" action="../server/action.php?id=<?php echo $id; ?>">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Stocks</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
    <small>Product Name</small>
    <h4><?php echo $row["Product_Name"]; ?></h4>
    <hr>
    <div class="row">
        <div class="col">
            <input type="number" class="form-control" name="quantity" min="1" style="margin-top: -0.25px" placeholder="Enter the quantity to add..." autocomplete="off" required>
        </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    <button type="submit" name="add-supplies-stock" class="btn btn-primary">Add Stocks</button>
  </div>
</form>