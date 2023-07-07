<?php
include './db.php';
session_start();
date_default_timezone_set('Asia/Jakarta');


// ---------  CONFIG HERE ------------
//$serverUrl = "http://192.168.0.102:8000";
$tokenPrefix = "UNFOLLTHEM-";
$expDayCount = 7; //day
// -----------------------------------
$manager = new Database();

// if POST == add Token
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $date = new DateTime(date('Y-m-d'));
    $date->modify('+' . $expDayCount . ' day'); // default expiration date
    $timestamp = time(); 

    $token = ($_POST['token'] == '') ? $tokenPrefix . $timestamp : $_POST['token'];
    $expiration = ($_POST['exp'] == '') ? $date->format('Y-m-d') : $_POST['exp'];
    $service = $_POST['service'];

    echo ($manager->addToken($token, $expiration, $service) == true) ? "<script>alert('Token berhasil ditambahkan')</script>" : "Internal Server Error";

}

//if DELETE == delete Token
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    
    if ($manager->deleteToken(substr($_SERVER['REQUEST_URI'], 9))) {
        //header('Location: '. $serverUrl);
        
    } else {
        die("Failed delete token!");
    }
}


$tokenList = $manager->getAllToken();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.4/css/bulma.min.css"
        integrity="sha512-HqxHUkJM0SYcbvxUw5P60SzdOTy/QVwA1JJrvaXJv4q7lmbDZCmZaqz01UPOaQveoxfYRv1tHozWGPMcuTBuvQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Open Sans', sans-serif;
        }
    </style>
    <title>Token Creator | Admin</title>
</head>

<body>
    <!-- nav -->
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand" style="padding: 8px;">
            <h1 class="subtitle">Admin</h1>

        </div>
    </nav>

    <div class="container" style="padding: 12px;">

        <div class="box">
            <h2 class="subtitle">Generate Token</h2>

            <form id="token-gen" method="post" action="/">
                <div class="field">
                    <label class="label">TOKEN</label>
                    <div class="control">
                        <input class="input" id="token" name="token" type="text" placeholder="example: LP-03912">
                        <p>Leave blank to randomly generate token</p>
                    </div>
                </div>
                <div class="field">
                    <label for="exp" class="label">Expiration</label>
                    <div class="control">
                        <input id="exp" class="input is-warning" name="exp" type="date" placeholder="SELECT DATE">
                        <p>Leave blank to apply default expiration (7d)</p>
                    </div>
                </div>

                <div class="field">
                    <label for="service" class="label">Service Type</label>
                    <div class="control">
                        <select id="service" class="input is-normal" name="service">
                            <option value="IG">IG</option>
                            <option value="TWT">TWT</option>
                        </select>
                    </div>
                </div>

                <button class="button is-primary">Generate</button>
            </form>

        </div>


        <div class="box">
            <h2 class="subtitle">Token List</h2>
            <div class="table-container">
                <table class="table is-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Token</th>
                            <th>Medsos</th>
                            <th>Exp Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                           <?php 
                           $num = 1;
                           foreach ($tokenList as $token) {
                            echo "<tr>"; 
                            echo "<th>".$num."</th>";
                            echo "<th>".$token['token']."</th>";
                            echo "<th>".$token['service']."</th>";
                            echo "<th>".$token['expire']."</th>";
                            echo "<th> <button class=\"button is-primary\" onclick=\"deleteToken('".$token['token']."')\" >DELETE</button> </th>";
                            echo "<tr>"; 
                            $num++;
                           }
                           
                           ?>
                    </tbody>

                </table>

            </div>
        </div>


    </div>
    <!-- end container -->


</body>
<script>
function deleteToken(token) {
    fetch("/?delete="+token, {
        method: 'DELETE'
    }).then((res) => {
        if (res == "Failed delete token!") {
            alert(res)
        }
        window.location = '/'
    })
}
</script>

</html>