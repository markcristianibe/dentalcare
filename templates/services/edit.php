<?php

include("../../server/db_connection.php");

$serviceId = mysqli_real_escape_string($conn, $_POST["serviceId"]);
$sqli = "SELECT * FROM tbl_services WHERE Service_ID = '$serviceId'";
$service = mysqli_query($conn, $sqli);
$result = mysqli_fetch_assoc($service);
?>

<form action="../server/action.php" method="POST">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    <script>
        document.getElementById("category").value = "<?php echo $result["Category"]; ?>"
    </script>
    <small>Service Description</small>
    <select id="category" class="form-control" name="service-category" required>
        <option value="Cosmetic Dentistry">Cosmetic Dentistry</option>
        <option value="Prosthodontics (Crowns and Dentures)">Prosthodontics (Crowns and Dentures)</option>
        <option value="Orthodontics (Braces)">Orthodontics (Braces)</option>
        <option value="Restoration (Fillings)">Restoration (Fillings)</option>
        <option value="Dental Implants">Dental Implants</option>
        <option value="Oral Examination">Oral Examination</option>
        <option value="Periodontics">Periodontics</option>
        <option value="Oral Surgery">Oral Surgery</option>
        <option value="Endodontics (Root Canal Therapy)">Endodontics (Root Canal Therapy)</option>
        <option value="TMJ Dysfunction">TMJ Dysfunction</option>
        <option value="CPediatric Dentistry">Pediatric Dentistry</option>
        <option value="X-Ray Services">X-Ray Services</option>
        <option value="CBCT Scan">CBCT Scan</option>
    </select>
    <small>Service Description</small>
    <textarea class="form-control" name="service-description"  autocomplete="off" required><?php echo $result["Service_Description"]; ?></textarea>
    <small>Charge (₱)</small>
    <input type="number" class="form-control" name="charge" min="1" value="<?php echo $result["Charge"]; ?>" required>
    <input type="text" value="<?php echo $result["Service_ID"]; ?>" class="visually-hidden" name="service-id">

    </div>
    <div class="modal-footer">
        <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
        <button type="submit" name="edit-service" class="btn btn-primary">Save</button>
    </div>
</form>

            