<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Meeting room booking system in PHP</title>

    <script>
        function validateForm() {
            var capacity = document.forms["myForm"]["capacity"].value;
            if (capacity == "") {
                alert("Capacity must be filled out");
                return false;
            }
            var startTime = document.forms["myForm"]["startTime"].value;
            var endTime = document.forms["myForm"]["endTime"].value;
            var isValid1 = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(startTime);
            var isValid2 = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(endTime);
            if (parseInt(startTime.replace(':', '')) >= parseInt(endTime.replace(':', ''))) {
                alert("End time must be after start time value");
                return false;
            }
            if (!isValid1 || !isValid2) {
                alert("Time must be format HH:MM");
                return false;
            }
            if (startTime == "") {
                alert("start time must be filled out");
                return false;
            }
            if (endTime == "") {
                alert("End time must be filled out");
                return false;
            }
        }
    </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>
</head>

<body>
    <div class="container"></a>
        <h1>Meeting room booking system</h1>


        <?php

        if (isset($_POST["bookRoom"])) {
            include_once('config.php');
            include_once('Rooms.class.php');
            $rooms = new Rooms(ROOMS_FEATURES);
            $rooms->readRoomsDatabase($_POST["datePicked"]);
            $roomsOk = $rooms->getAvailableRooms($_POST["startTime"], $_POST["endTime"]);
            $roomIdAssigned = $rooms->getOptimizedCapacityRoom($roomsOk, $_POST["capacity"]);
            if ($roomIdAssigned > 0) {
                $rooms->writeRoomsDatabase($_POST["startTime"], $_POST["endTime"], $roomIdAssigned);
                echo '<div class="alert alert-success" role="alert"><b>Room ID ' . $roomIdAssigned . '</b> assigned on <b>'.$_POST["datePicked"].'</b> for <b>' . $_POST["capacity"] . ' people</b> and time frame <b>' . $_POST["startTime"] . 'h - ' . $_POST["endTime"] . 'h</b>.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Sorry, not meeting room available on <b>'.$_POST["datePicked"].'</b> for <b>' . $_POST["capacity"] . ' people</b> and time frame <b>' . $_POST["startTime"] . 'h - ' . $_POST["endTime"] . 'h</b>.</div>';
            }
            echo "<hr>";
            echo "<h3>Rooms booked on " . $_POST["datePicked"] . ":</h3>";
            $rooms->printRoomsDatabase($_POST["datePicked"]);
            echo "<hr>";
        }

        ?>


        <br>
        <h3>Booking form:</h3>
        <form name="myForm" action="index.php" method="post" onsubmit="return validateForm()">
            <input type="hidden" name="bookRoom">
            <div class="mb-3">
                <label for="Date" class="form-label">Date:</label><input type="text" name="datePicked" id="datepicker">
                <label for="Start time" class="form-label">Start time:</label>
                <select name="startTime">
                    <option value="0:00">0:00h</option>
                    <option value="1:00">1:00h</option>
                    <option value="2:00">2:00h</option>
                    <option value="3:00">3:00h</option>
                    <option value="4:00">4:00h</option>
                    <option value="5:00">5:00h</option>
                    <option value="6:00">6:00h</option>
                    <option value="7:00">7:00h</option>
                    <option value="8:00">8:00h</option>
                    <option value="9:00">9:00h</option>
                    <option value="10:00">10:00h</option>
                    <option value="11:00">11:00h</option>
                    <option value="12:00">12:00h</option>
                    <option value="13:00">13:00h</option>
                    <option value="14:00">14:00h</option>
                    <option value="15:00">15:00h</option>
                    <option value="16:00">16:00h</option>
                    <option value="17:00">17:00h</option>
                    <option value="18:00">18:00h</option>
                    <option value="19:00">19:00h</option>
                    <option value="20:00">20:00h</option>
                    <option value="21:00">21:00h</option>
                    <option value="22:00">22:00h</option>
                    <option value="23:00">23:00h</option>
                </select>
                <label for="End time" class="form-label">End time:</label>
                <select name="endTime">
                <option value="0:00">0:00h</option>
                    <option value="1:00">1:00h</option>
                    <option value="2:00">2:00h</option>
                    <option value="3:00">3:00h</option>
                    <option value="4:00">4:00h</option>
                    <option value="5:00">5:00h</option>
                    <option value="6:00">6:00h</option>
                    <option value="7:00">7:00h</option>
                    <option value="8:00">8:00h</option>
                    <option value="9:00">9:00h</option>
                    <option value="10:00">10:00h</option>
                    <option value="11:00">11:00h</option>
                    <option value="12:00">12:00h</option>
                    <option value="13:00">13:00h</option>
                    <option value="14:00">14:00h</option>
                    <option value="15:00">15:00h</option>
                    <option value="16:00">16:00h</option>
                    <option value="17:00">17:00h</option>
                    <option value="18:00">18:00h</option>
                    <option value="19:00">19:00h</option>
                    <option value="20:00">20:00h</option>
                    <option value="21:00">21:00h</option>
                    <option value="22:00">22:00h</option>
                    <option value="23:00">23:00h</option>
                </select>
                <label for="Capacity needed" class="form-label">Capacity:</label>
                <select name="capacity">
                    <option value="2">2 pers.</option>
                    <option value="3">3 pers.</option>
                    <option value="4">4 pers.</option>
                    <option value="5">5 pers.</option>
                    <option value="6">6 pers.</option>
                    <option value="7">7 pers.</option>
                    <option value="8">8 pers.</option>
                    <option value="9">9 pers.</option>
                    <option value="10">10 pers.</option>
                    <option value="11">11 pers.</option>
                    <option value="12">12 pers.</option>
                    <option value="13">13 pers.</option>
                    <option value="14">14 pers.</option>
                    <option value="15">15 pers.</option>
                    <option value="16">16 pers.</option>
                    <option value="17">17 pers.</option>
                    <option value="18">18 pers.</option>
                    <option value="19">19 pers.</option>
                    <option value="20">20 pers.</option>
                    <option value="21">21 pers.</option>
                    <option value="22">22 pers.</option>
                    <option value="23">23 pers.</option>
                    <option value="24">24 pers.</option>
                    <option value="25">25 pers.</option>
                </select> 
                <input type="submit" value="Book room">
            </div>
        </form>


        <br><br><br>
        <br><div align=center>Script created by <a href="https://www.fernando.info">Fernando</a>.</div>

        <br><br><br><br><br><br>
    </div>
</body>

</html>