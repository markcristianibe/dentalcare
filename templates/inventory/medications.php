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
            $("#txt-search").keyup(function(){
                var txt = $(this).val();
                $.ajax({
                    method: 'post',
                    url: '../templates/inventory/search-medications.php',
                    data: {
                        search: txt
                    },
                    datatype: "text",
                    success: function(data){
                        $("#table-data").html(data);
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
            <div class="form"> <i class="fa fa-search fa-icon"></i> <input type="text" id="txt-search" class="form-control form-input" placeholder="Search for Product Name..." autocomplete="off"> <span class="left-pan">Search</span> </div>
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
                <th scope="col">Stocks</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="table-data">
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
                        while($row = mysqli_fetch_array($query))
                        {
                            $stocks += $row["Quantity"];
                        }
                        ?>

                        <td><?php echo $stocks; ?></td>

                        <td>
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