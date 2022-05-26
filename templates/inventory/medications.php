    <script>
        document.getElementById("medicines-tab").classList.add("active");

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
                    url: '../templates/inventory/search-medications.php',
                    data: {
                        search: txt
                    },
                    datatype: "text",
                    success: function(data){
                        $("#table_data").html(data);
                    }
                });
            });
        });
    </script>

    <?php
    include("../templates/modals/add-medication-modal.php");

    if(isset($_GET["error"]))
    {
        ?>
        <script>
            alert("Please Fill All Required Fields.");
            window.location.href = "../admin/homepage.php?page=inventory&tab=medications";
        </script>
        <?php
    }

    $sql = "SELECT * FROM tbl_medications";
    ?>

    <div class="container">
      <div class="row">
        <div class="col">
            <div class="form"> <i class="fa fa-search fa-icon"></i> <input type="text" id="txtSearch" class="form-control form-input" placeholder="Search for Product Name..." autocomplete="off"> <span class="left-pan">Search</span> </div>
        </div>
      </div>
      <hr class="dropdown-divider">
    </div>

    <button id="addBtn" class="btn floating-btn" data-bs-toggle="modal" data-bs-target="#add-medication-modal" onmouseover="btn_onHover()" onmouseleave="btn_onLeave()"><h1 id="addBtn-txt">+</h1></button>
    
    <div id="data" class="container-fluid">
        <table id="tbl-patients" class="table table-striped table-fixed">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Expiry Date</th>
                <th scope="col">Stocks</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="table_data">
                <?php
                $sql = "SELECT * FROM tbl_medications";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0)
                {
                    $count = 1;
                    while ($med = mysqli_fetch_array($result))
                    {
                        ?>
                        <tr>
                        <th scope='row'><?php echo $count++; ?></th>
                        <td><?php echo $med["Brand"] . " " . $med["Name"] . " " . $med["Unit"]; ?></td>
                        
                        <?php
                        $stocks = 0;
                        $id = $med["Product_ID"];
                        $query = mysqli_query($conn, "SELECT * FROM tbl_batches WHERE Product_ID = '$id'");
                        $exp;
                        while($row = mysqli_fetch_array($query))
                        {
                            $stocks += $row["Quantity"];
                            $exp = date_create($row["Expiry_Date"]);
                        }
                        ?>
                        <td><?php echo date_format($exp, "M d, Y"); ?></td>
                        <?php
                        if($stocks <= $med["Par_Stock_Level"])
                        {
                            ?>
                            <td class="text-danger"><?php echo $stocks; ?></td>
                            <?php
                        }
                        else
                        {
                            ?>
                            <td class="text-dark"><?php echo $stocks; ?></td>
                            <?php
                        }
                        ?>
                        

                        <td>
                            <a href='#' class='circle btn btn-success'  data-bs-toggle='modal' data-bs-target='#edit-medication-modal' onclick="editSupply(<?php echo $med['Product_ID']; ?>)"><i class="fa fa-pen"></i></a>
                            <a href='#' class='circle btn btn-danger' onclick='deleteMedication(<?php echo $med["Product_ID"]; ?>)'><i class="fa fa-trash"></i></a>
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

    <div class="modal fade" id="edit-medication-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div id="edit-supply-content" class="modal-content text-dark">
        
            </div>
        </div>
    </div>

    <script>
        function editSupply(id) {
            $.ajax({
                method: 'post',
                url: '../templates/modals/edit-medication-modal.php',
                data: {
                    productId: id,
                },
                datatype: "text",
                success: function(data){
                    $("#edit-supply-content").html(data);
                }
            });
        }

        function deleteMedication(id) {
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