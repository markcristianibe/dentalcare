    <script>
        document.getElementById("supplies-tab").classList.add("active");
        
        function btn_onHover()
        {
            document.getElementById("addBtn-txt").innerHTML = "+ Add Item"
            document.getElementById("addBtn").style.width = "350px"
            document.getElementById("addBtn").style.borderRadius = "50px"
        }

        function btn_onLeave()
        {
            document.getElementById("addBtn-txt").innerHTML = "+"
            document.getElementById("addBtn").style.width = "70px"
            document.getElementById("addBtn").style.borderRadius = "50%"
        }

        $(document).ready(function(){
            $("#txtSearch").keyup(function(){
                var txt = $(this).val();
                $.ajax({
                    method: 'post',
                    url: '../templates/inventory/search-supplies.php',
                    data: {
                        search: txt,
                        category: document.getElementById("filterCategory").value
                    },
                    datatype: "text",
                    success: function(data){
                        $("#table_data").html(data);
                    }
                });
            });

            $("#filterCategory").change(function(){
                var txt = $("#txtSearch").val();
                $.ajax({
                    method: 'post',
                    url: '../templates/inventory/search-supplies.php',
                    data: {
                        search: txt,
                        category: document.getElementById("filterCategory").value
                    },
                    datatype: "text",
                    success: function(data){
                        $("#table_data").html(data);
                    }
                });
            });
            
        });

        function addStocks(id) {
            $.ajax({
                method: 'post',
                url: '../templates/modals/add-stocks-modal.php',
                data: {
                    productId: id,
                },
                datatype: "text",
                success: function(data){
                    $("#add-stocks-content").html(data);
                }
            });
        }

        function editSupply(id) {
            $.ajax({
                method: 'post',
                url: '../templates/modals/edit-supplies-modal.php',
                data: {
                    productId: id,
                },
                datatype: "text",
                success: function(data){
                    $("#edit-supply-content").html(data);
                }
            });
        }

        function deleteSupply(id) {
            if(confirm("Are you sure you want to remove this item from the inventory?")) {
                $.ajax({
                    method: 'post',
                    url: '../server/action.php',
                    data: {
                        productId: id,
                        action: "delete-supply-item"
                    },
                    datatype: "text",
                    success: function(){
                        window.location.href = "../admin/homepage.php?page=inventory&tab=supplies";
                    }
                });
            }
        }
    </script>

    <?php
    $sql = "SELECT * FROM tbl_supplies";
    ?>
    <div class="container">
      <div class="row">
        <div class="col-md-7">
            <div class="form"> <i class="fa fa-search fa-icon"></i> <input type="text" id="txtSearch" class="form-control form-input" placeholder="Search for Product Name..." autocomplete="off"> <span class="left-pan">Search</span> </div>
        </div>
        <div class="col-md-5">
            <div class="form">  
                <div class="dropdown">
                    <p class="fa fa-icon">&#xf0b0</p>
                    <select id="filterCategory" class="form-select form-input">
                        <option value="All">All</option>
                        <option value="Diagnostic Instruments/Accessories">Diagnostic Instruments/Accessories</option>
                        <option value="Sterilization Instruments/Accessories">Sterilization Instruments/Accessories</option>
                        <option value="Surgery Instruments/Accessories">Surgery Instruments/Accessories</option>
                        <option value="Prosthodontic Instruments/Accessories">Prosthodontic Instruments/Accessories</option>
                        <option value="Orthodontic Instruments">Orthodontic Instruments</option>
                        <option value="Endodontic Materials">Endodontic Materials</option>
                    </select>
                </div> 
            </div>
        </div>
      </div>
      <hr class="dropdown-divider">
    </div>

    <button id="addBtn" class="btn floating-btn" data-bs-toggle="modal" data-bs-target="#add-supplies-modal" onmouseover="btn_onHover()" onmouseleave="btn_onLeave()"><h1 id="addBtn-txt">+</h1></button>

    <div id="data" class="container-fluid">
        <table id="tbl-patients" class="table table-striped table-fixed">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Stocks</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="table_data">
                <?php
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0)
                {
                    $count = 1;
                    while ($spl = mysqli_fetch_array($result))
                    {
                        ?>
                        <tr>
                        <th scope='row'><?php echo $count++; ?></th>
                        <td><?php echo $spl["Product_Name"]; ?></td>

                        <?php
                        if($spl["Stocks"] <= $spl["Par_Stock_Level"])
                        {
                            ?>
                            <td class="text-danger"><?php echo $spl["Stocks"]; ?></td>
                            <?php
                        }
                        else
                        {
                            ?>
                            <td class="text-dark"><?php echo $spl["Stocks"]; ?></td>
                            <?php
                        }
                        ?>
                        <td>
                            <a href='#' class='circle btn btn-primary'  data-bs-toggle='modal' data-bs-target='#add-stocks-modal' onclick="addStocks(<?php echo $spl['Product_ID']; ?>)"><i class="fa fa-plus"></i></a>
                            <a href='#' class='circle btn btn-success'  data-bs-toggle='modal' data-bs-target='#edit-supplies-modal' onclick="editSupply(<?php echo $spl['Product_ID']; ?>)"><i class="fa fa-pen"></i></a>
                            <a href='#' class='circle btn btn-danger' onclick='deleteSupply(<?php echo $spl["Product_ID"]; ?>)'><i class="fa fa-trash"></i></a>
                        </td>
                        </tr>
                        <?php
                    }
                }
                else
                {
                    echo "<tr>
                    <th colspan='5'>No Results Found...</th>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="add-stocks-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div id="add-stocks-content" class="modal-content text-dark">
            
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-supplies-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="edit-supply-content" class="modal-content text-dark">
        
    </div>
  </div>
</div>