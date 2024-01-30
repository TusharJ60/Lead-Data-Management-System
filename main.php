<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" content="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <!-- Include DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <title>Data Management System</title>
</head>

<body style="margin: 50px; border: 30px;">
    <h1>Data Management System</h1>
    <br>
    <table class="table table-striped table-bordered text-center" id="myTable">
        <thead>
            <tr class="bg-dark text-white">
            <th>Lead ID</th>
            <th>Name</th>
            <th>Mobile/Alternate/Whatsapp/Email</th>
                <th>State/City</th>
                <th>Intrested In</th>
                <th>Source</th>
                <th>Status</th>
                <th>DOR</th>
                <th>Summary DOR</th>
                <th>Option</th>
                <th>Caller</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'connect.php';
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "kalam_test";
            $conn = mysqli_connect($servername, $username, $password, $database);
            $a = 10;
            $b=25;
            $c=50;
            $d=100;
            ?>
            <form action="/first/init.php" method="post" name="mylog">
           <div ><input type="text" id="input" name="Limit">
            <button onclick="setLimit()">Set Limit</button>
        </div>
</form>
            <?php
                $limit = isset($_POST['Limit']) ? (int)$_POST['Limit'] : 10;
                if($limit>=256386){
                    $limit=256386;
                }
            

            $sql = "SELECT * FROM `crm_lead_master_data` LIMIT $limit";

            $result = mysqli_query($conn, $sql);

            $sql2 = "SELECT * FROM crm_calling_status LIMIT $limit";

            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            $sql3 = "SELECT * FROM crm_admin LIMIT $limit";
            $result3 = mysqli_query($conn, $sql3);
            $row3 = mysqli_fetch_assoc($result3);

            $tables = array("crm_lead_master_data", "crm_calling_status", "crm_admin");

            // Initialize total count
            $total = 0;
            
            // Loop through each table
            foreach ($tables as $table) {
                $ginti = "SELECT COUNT(*) as count FROM `$table`";
                $parinaam = mysqli_query($conn, $ginti);
            
                if ($parinaam) {
                    $column = mysqli_fetch_assoc($parinaam);
                    $total += $column['count'];
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
             $total;
            $i = 0;
            $j = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $mobileColumn = $row["Mobile"] . '/' . $row["Alternate_Mobile"] . '/' . $row["Whatsapp"] . '/' . $row["Email"];
                $conditionColumn = (stripos($row["Status"], 'DEAD') === false) ? 'style="background-color:red;"' : 'DEAD';

                echo "<tr>
                <td>" . $row["Lead_ID"] . "</td>
                <td>" . $row["Name"] . "</td>
                <td>" . $mobileColumn . "</td>
                <td>" . $row["State"] . "</td>
                <td>" . $row["Interested_In"] . "</td>
                <td>" . $row["Source"] . "</td>
                <td $conditionColumn>" . $row["Status"] . "</td>
                <td>" . $row["DOR"] . "</td>";

                // Reset the internal pointer of result2 to the beginning
            
                mysqli_data_seek($result2, $i);

                while ($row2 = mysqli_fetch_assoc($result2)) {
                    echo "<td>" . $row2["DOR"] . "</td>";
                    $i++;
                    break;
                }

                echo "<td>
                <a class='btn btn-outline-dark' href='edit.php' id=" . $row['Status'] . "'>Edit Status</a>
              </td>";

                // Reset the internal pointer of result3 to the beginning
                mysqli_data_seek($result3, $j);

                while ($row3 = mysqli_fetch_assoc($result3)) {
                    echo "<td>" . $row3["Name"] . "</td>";
                    $j++;
                    break;
                }

                echo "</tr>";
            }
            // $sql2 = "SELECT * FROM crm_calling_status LIMIT 10";
            
            // $result2 = mysqli_query($conn, $sql2);
            // $row2 = mysqli_fetch_assoc($result2);
            



            // $result = mysqli_query($conn, $sql);
// while ($row = mysqli_fetch_assoc($result)) {
//     // Concatenate Mobile, Alternate_Mobile, Whatsapp, and Email columns
//     // $mobileColumn = $row["Mobile"] . '/' . $row["Alternate_Mobile"] . '/' . $row["Whatsapp"] . '/' . $row["Email"];
// 
            
            // }
            ?>

        </tbody>
    </table>

    <div id="result"></div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>