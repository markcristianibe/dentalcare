<div class="modal fade" id="add-service-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="../server/action.php" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <small>Service Description<span class="text-danger"> *</span></small>
                <select class="form-select" name="service-category" required>
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
                <small>Service Description<span class="text-danger"> *</span></small>
                <textarea class="form-control" name="service-description" autocomplete="off" required></textarea>
                <small>Charge (₱)<span class="text-danger"> *</span></small>
                <input type="number" class="form-control" name="charge" min="1" required>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                <button type="submit" name="add-service" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>