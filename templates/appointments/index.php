<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    document.getElementById("appointments-btn").classList.add("active")
</script>
<?php 
    include("../templates/modals/set-appointment-modal.php");
?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      themeSystem: 'bootstrap5',     
      headerToolbar: {
        right: 'today,prev,next',
        center: 'title',
        left: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      dateClick: function(info) {
          var dateNow = new Date();
          var dateSelected = new Date(info.dateStr);

            if(dateSelected.getFullYear() >= dateNow.getFullYear()){
                if(dateSelected.getDay() > 0) {
                    if(dateSelected.getMonth() == dateNow.getMonth()){
                        if(dateSelected.getDate() >= dateNow.getDate()){
                            document.getElementById("dateAppointed").innerHTML = "Date: " + info.dateStr;
                            document.getElementById("txt-date").value = info.dateStr;

                            $("#set-appointment-modal").modal("show");
                        }
                    }
                    else if(dateSelected.getMonth() > dateNow.getMonth()) {
                        document.getElementById("dateAppointed").innerHTML = "Date: " + info.dateStr;
                        document.getElementById("txt-date").value = info.dateStr;

                        $("#set-appointment-modal").modal("show");
                    }
                }
                else {  
                    alert("Clinic is close every Sunday!");
                }
            }
      },
      timeZone: 'UTC',
      editable: true,
      events: [
          <?php
          $sql = "SELECT tbl_appointment.ID, tbl_patientinfo.Lastname, tbl_patientinfo.Firstname, tbl_appointment.Date, tbl_appointment.Start, tbl_appointment.End FROM tbl_appointment, tbl_patientinfo WHERE tbl_appointment.Status = 'pending' AND tbl_appointment.Patient_ID = tbl_patientinfo.Patient_ID";
          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)) {
                  echo "{
                      allDay: false,
                      timeZone: 'UTC',
                      id: '". $row["ID"] ."',
                      title: '". $row["Lastname"] . ", " . $row["Firstname"] ."',
                      start: '". $row["Date"] . "T" . $row["Start"] ."',
                      end: '". $row["Date"] . "T" . $row["End"] ."',
                      backgroundColor: 'green'
                  },";
              }
          }
          ?>
      ],
      eventDrop: function(info) {
        var s = new Date(info.event.start);
        var e = new Date(info.event.end);
        if(s.getDay() > 0) {
            if((s.getHours() >= 0 && s.getHours() <= 4) || (s.getHours() >= 16 && s.getHours() <= 23)) {
                if (confirm("Are you sure you want to move " + info.event.title + " appointment?")) {
                    let d;
                    if(s.getMonth().length > 1) {
                        d = s.getFullYear() + "-" + parseInt(s.getMonth()+1).toString() + "-" + s.getDate();
                    }
                    else {
                        d = s.getFullYear() + "-0" + parseInt(s.getMonth()+1).toString() + "-" + s.getDate();
                    }

                    let hs;
                    if(s.getHours() == 16) {
                        hs = 8;
                    } else if(s.getHours() == 17) {
                        hs = 9;
                    } else if(s.getHours() == 18) {
                        hs = 10;
                    } else if(s.getHours() == 19) {
                        hs = 11;
                    } else if(s.getHours() == 20) {
                        hs = 12;
                    } else if(s.getHours() == 21) {
                        hs = 13;
                    } else if(s.getHours() == 22) {
                        hs = 14;
                    } else if(s.getHours() == 23) {
                        hs = 15;
                    } else if(s.getHours() == 0) {
                        hs = 16;
                    } else if(s.getHours() == 1) {
                        hs = 17;
                    } else if(s.getHours() == 2) {
                        hs = 18;
                    } else if(s.getHours() == 3) {
                        hs = 19;
                    } else if(s.getHours() == 4) {
                        hs = 20;
                    }

                    let he;
                    if(e.getHours() == 16) {
                        he = 8;
                    } else if(e.getHours() == 17) {
                        he = 9;
                    } else if(e.getHours() == 18) {
                        he = 10;
                    } else if(e.getHours() == 19) {
                        he = 11;
                    } else if(e.getHours() == 20) {
                        he = 12;
                    } else if(e.getHours() == 21) {
                        he = 13;
                    } else if(e.getHours() == 22) {
                        he = 14;
                    } else if(e.getHours() == 23) {
                        he = 15;
                    } else if(e.getHours() == 0) {
                        he = 16;
                    } else if(e.getHours() == 1) {
                        he = 17;
                    } else if(e.getHours() == 2) {
                        he = 18;
                    } else if(e.getHours() == 3) {
                        he = 19;
                    } else if(e.getHours() == 4) {
                        he = 20;
                    }

                    $.ajax({
                        method: 'post',
                        url: '../server/action.php',
                        data: {
                            action: 'resched-appointment',
                            aid: info.event.id,
                            date: d,
                            start: hs + ":" + s.getMinutes(),
                            end: he + ":" + e.getMinutes(),
                        }
                    });
                }
                else{
                    info.revert();
                }
            }
            else {
                alert("Clinic Hours is 8:00 am - 9:00 pm");
                info.revert();
            }
        }
        else {
            alert("Clinic is close every Sunday!");
            info.revert();
        }
      },
      eventClick: function(info) {
          
          var aId = info.event.id;
          $.ajax({
              method: 'post',
              url: '../templates/modals/appointment-event-clicked-modal.php',
              data: { id: aId },
              datatype: "text",
              success: function(data){
                $("#modal-content").html(data);
              }
          });
          $("#appointment-event-clicked").modal("show");
      },
      businessHours: {
        daysOfWeek: [ 1, 2, 3, 4, 5, 6 ],
        startTime: '08:00',
        endTime: '21:00',
      }
    });
    calendar.render();
  });

</script>

<?php
if(isset($_GET["return"]))
{
    if($_GET["return"] == 0)
    {
        echo '<script>
            alert("Failed: Patient can only set one appointment a day");
            window.location.href="../admin/homepage.php?page=appointments";
        </script>';
    }
    else if($_GET["return"] == 1)
    {
        echo '<script>
            alert("Failed: Selected time is unavailable");
            window.location.href="../admin/homepage.php?page=appointments";
        </script>';
    }
    
    
}
?>

<div class="modal fade" id="appointment-event-clicked" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div id="modal-content" class="modal-content" style="color: black">
      
    </div>
  </div>
</div>

<div class="container">
    <h3 style="color: dodgerblue">Appointments</h3>
    <div class="container">
        <div class="row">
            <div class="col">
                <div id="calendar"><div>
            </div>
        </div>
    </div>
</div>

<style>
    .container {
        margin: 20px 10px;
        color: #313131;
    }
</style>