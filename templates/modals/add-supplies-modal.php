<div class="modal fade" id="add-supplies-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="../server/action.php" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Supplies</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <small>Item Category<span class="text-danger"> *</span></small>
                <select class="form-select" name="supply-category" required>
                        <option>---</option>
                        <option>Diagnostic Instruments/Accessories</option>
                        <option>Sterilization Instruments/Accessories</option>
                        <option>Surgery Instruments/Accessories</option>
                        <option>Prosthodontic Instruments/Accessories</option>
                        <option>Orthodontic Instruments</option>
                        <option>Endodontic Materials</option>
                </select>
                <small>Product Name<span class="text-danger"> *</span></small>
                <textarea class="form-control" name="supply-name" autocomplete="off" required></textarea>
                <div class="row">
                    <div class="col">
                        <small>Stocks<span class="text-danger"> *</span></small>
                        <input type="number" class="form-control" name="stocks" min="1" required>
                    </div>
                    <div class="col">
                        <small>Par Stock Level<span class="text-danger"> *</span></small>
                        <input type="number" class="form-control" name="psl" min="1" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                <button type="submit" name="add-supply" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>