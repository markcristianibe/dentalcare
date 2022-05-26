<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    document.getElementById("inventory-btn").classList.add("active")
</script>

<div class="container">
    <h3 style="color: dodgerblue">Inventory</h3>

    <ul class="nav nav-tabs flex-column flex-sm-row">
        <li class="nav-item">
            <a href="homepage.php?page=inventory&tab=supplies" id="supplies-tab" class="nav-link">Supplies</a>
        </li>
        <li class="nav-item">
            <a href="homepage.php?page=inventory&tab=medications" id="medicines-tab" class="nav-link">Medicines</a>
        </li>
    </ul>

    <div class="content">
        <?php
        include("../server/db_connection.php");
        if(isset($_GET["tab"]))
        {
          $tab = $_GET['tab'];
          $loc = "../templates/inventory/" . $tab . ".php";
          include($loc);
        }
        else
        {
          include("../templates/inventory/supplies.php");
        }
        ?>
    </div>
</div>
<style>
    .container{
        margin: 20px 10px;
    }
    .box-item{
        background: dodgerblue;
    }
    .floating-btn{
        width: 70px;
        height: 70px;
        background-color: dodgerblue;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.50);
        position: fixed;
        right: 50px;
        bottom: 30px;
        transition: background 0.25s;
        z-index: 1;
    }
    .floating-btn:hover, .floating-btn:active{
        background-color: rgb(22, 118, 214);
        color: white;
    }
    .form {
        position: relative
    }
    .form .fa-icon {
        position: absolute;
        top: 20px;
        left: 5px;
        color: #9ca3af
    }
    .fa{
        color: #fff;
    }
    .circle{
        border-radius: 50%;
    }
    .form span {
        position: absolute;
        right: 17px;
        top: 13px;
        padding: 2px;
        border-left: 1px solid #d1d5db
    }
    .left-pan {
        padding-left: 20px
    }
    .form-control, .form-select {
        margin: 5px 0 5px 0;
    }
    .form-input {
        margin: 5px 0 5px -15px;
        height: 55px;
        text-indent: 33px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.50);
        border-radius: 10px
    } 
    .container-fluid {
        position: relative;
        height: 380px;
        width: auto;
        overflow: auto;
        display: block;
    }
</style>