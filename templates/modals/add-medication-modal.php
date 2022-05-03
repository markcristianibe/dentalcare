<script>
    function addMedication() {
        document.getElementById("add-medication").classList.add("active");
        document.getElementById("add-batch").classList.remove("active");
        document.getElementById("con-medication").classList.remove("visually-hidden");
        document.getElementById("con-batch").classList.add("visually-hidden");
        document.getElementById("submit-btn").name = "addMedication";
    }

    function addBatch() {
        document.getElementById("add-medication").classList.remove("active");
        document.getElementById("add-batch").classList.add("active");
        document.getElementById("con-medication").classList.add("visually-hidden");
        document.getElementById("con-batch").classList.remove("visually-hidden");
        document.getElementById("submit-btn").name = "addBatch";
    }
</script>


<div class="modal fade" id="add-medication-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-dark">
      <form method="POST" action="../server/action.php">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Item</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a id="add-medication" class="nav-link active" aria-current="page" onclick="addMedication()">Add Medication</a>
                </li>
                <li class="nav-item">
                    <a id="add-batch" class="nav-link" onclick="addBatch()">Create New Batches</a>
                </li>
            </ul>

            <div id="con-medication" class="content">
                <br>
                <div class="row">
                    <div class="col">
                        <small>Brand Name<span class="text-danger"> *</span></small>
                        <input type="text" name="brand" class="form-control">   
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <small>Product Name<span class="text-danger"> *</span></small>
                        <input type="text" name="name" class="form-control">   
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <small>Dosage<span class="text-danger"> *</span></small>
                        <input type="text" name="dosage" class="form-control">   
                    </div>
                    <div class="col">
                        <small>Price<span class="text-danger"> *</span></small>
                        <input type="number" name="price" class="form-control">   
                    </div>
                    <div class="col">
                        <small>Par Stock Level<span class="text-danger" min="1"> *</span></small>
                        <input type="number" name="psl" class="form-control" min="1">   
                    </div>
                </div>
            </div>
            <div id="con-batch" class="content visually-hidden">
                <br>
                <div class="row">
                    <div class="col">
                        <small>Product Name<span class="text-danger"> *</span></small>
                        <input type="text" id="form-autocomplete" name="id" class="form-control" list="patient-list" placeholder="Type Item Name..." autocomplete="off">
                        <datalist id="patient-list">
                            <?php
                            
                            include("../server/db_connection.php");

                            $sql = "select * from tbl_medications";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0)
                            {
                                while($row = mysqli_fetch_array($result))
                                {
                                    echo "<option value='". $row["Product_ID"] ."'>". $row["Brand"] . " " . $row["Name"] ."</option>";
                                }
                            }
                            ?>
                        </datalist>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <small>Quantity<span class="text-danger"> *</span></small>
                        <input type="number" name="quantity" min="1" class="form-control">   
                    </div>
                    <div class="col">
                        <small>Expiry Date<span class="text-danger"> *</span></small>
                        <input type="date" min="1" name="expiry" class="form-control">   
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="submit-btn" name="addMedication" type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>