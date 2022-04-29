<script>
    function tableSearch(){
        let input, filter, table, tr, td, txtValue;

        input = document.getElementById("txtInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("tblServices");
        tr = table.getElementsByTagName("tr");

        for(let i = 0; i < tr.length; i++){
            td = tr[i].getElementsByTagName("td")[1];
            if(td){
                txtValue = td.textContent || td.innerText;
                if(txtValue.toUpperCase().indexOf(filter) > -1){
                    tr[i].style.display = "";
                }
                else{
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function countChecked(){
        var form = document.forms["main"];
        var count = form.querySelectorAll('input[type="checkbox"]:checked');
        document.getElementById("count").innerHTML = count.length;
    }

    function changeEndMin() {
        document.getElementById("endTime").min = document.getElementById("startTime").value;
    }
</script>
<div class="modal fade" id="set-appointment-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="color: black">
      <form name="main" method="POST" action="../server/action.php">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Set New Appointment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h6 id="dateAppointed" name="date"></h6>
            <div class="row">
                <div class="col">
                    <small>Start of Procedure: (Office Hours: 8:00 AM - 9:00 PM)<span class="text-danger"> *</span></small>
                    <input type="time" id="startTime" name="start" class="form-control" min="08:00" max="21:00" onchange="changeEndMin()" required>
                </div>
                <div class="col">
                    <small>End of Procedure:<span class="text-danger"> *</span></small>
                    <input type="time" id="endTime" name="end" class="form-control" min="08:00" max="21:00" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <small>Patient Name:<span class="text-danger"> *</span></small>
                    <input type="text" id="form-autocomplete" name="id" class="form-control" list="patient-list" placeholder="Type Patient Name or Patient ID..." required>
                    <datalist id="patient-list">
                        <?php
                        
                        include("../server/db_connection.php");

                        $sql = "select * from tbl_patientinfo";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                                $rawDate = date_create($row["Date_Registered"]);
                                $dateRegistered = date_format($rawDate, "ymd");
                                $pid = "PID-" . $dateRegistered . "-" . $row["Patient_ID"];
                                echo "<option value='". $pid ."'>". $row["Firstname"] . " " . $row["Lastname"] ."</option>";
                                
                            }
                        }

                        ?>
                    </datalist>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <small>Select Services:<span class="text-danger"> *</span></small>
                    <input type="text" id="txtInput" class="form-control" placeholder="Search Services..." onkeyup="tableSearch()" autocomplete="off">
                    <div class="scroll">
                    <table id="tblServices" class="table">
                        <thead>
                            <th>#</th>
                            <th scope="col">Service Description</th>
                            <th scope="col">Charge</th>
                        </thead>
                        <tbody>
                            <?php
                                
                            include("../server/db_connection.php");

                            $sql = "select * from tbl_services";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0)
                            {
                                while($row = mysqli_fetch_array($result))
                                {
                                    echo "<tr>";
                                        echo "<td><input id='". $row["Service_ID"] ."' type='checkbox' name='service[]' value=". $row["Service_ID"] ." onclick='countChecked()'></td>";
                                        echo "<td><label for='". $row["Service_ID"] ."'>". $row["Service_Description"] ."</label></td>";
                                        echo "<td>₱". number_format($row["Charge"]) ."</td>";
                                    echo "</tr>";
                                }
                            }

                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <p>Selected Procedures: <b id="count" class="text-primary">0</b></p>
            <input id="txt-date" type="date" name="txt-date" class="visually-hidden">
            <a class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
            <button type="submit" name="set-appointment" class="btn btn-primary">Set</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
    .scroll{
        position: relative;
        height: 180px;
        overflow: auto;
        display: block;
    }
</style>