<!doctype html5>
<html>
    <head>
        <title>What you prefer?</title>
        <link href="css/welcome.css" rel="stylesheet" type="text/css" />
        <link href="css/buttons.css" rel="stylesheet" type="text/css" />
        <link href="css/images.css" rel="stylesheet" type="text/css" />
        <link href="css/statistic.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>		
    </head>
    <body>
        <div w3-include-html="html/header.html"></div>

        <div id="content">
            <table>
                <colgroup>
                    <col span="1" style="width: 10%;">
                    <col span="1" style="width: 35%;">
                    <col span="1" style="width: 8%;">
                    <col span="1" style="width: 8%;">
                    <col span="1" style="width: 8%;">
                </colgroup>

                <tr align=center class='first-row'>
                    <td> Photo </td>
                    <td> Instagram </td>
                    <td> Likes </td>
                    <td> Viewed </td>
                    <td> Rating </td>
                </tr>

                <?php 
                    $db = "you_prefer";
                    $host = "localhost";
                    $user = "root";
                    $pass = "";
                    
                    $conn = mysqli_connect($host, $user, $pass, $db);
                    if ($conn)
                    {
                        echo "<script>console.log('OK');</script>";
                    }

                    $sql = "SELECT g.*, 
                    case when g.clicks > 0
                        then (g.clicks / g.views)
                        else (0 - g.views) 
                    end as rating 
                    FROM girls g order by rating DESC, g.views DESC " . 
                    ((isset($_GET['limit']) && is_numeric($_GET['limit'])) ? ('limit ' . $_GET['limit']) : " limit 40");
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) 
                    {
                        // output data of each row
                        while($row = $result->fetch_assoc()) 
                        {
                            echo "
                                <tr align=center class='row'>
                                    <td>
                                        <img 
                                            width=\"100%\"
                                            src=" . $row['photo_url'] . " /> 
                                    </td>
                                    <td>" . $row['instagram_username'] . "</td>
                                    <td>" . $row['clicks'] . "</td>
                                    <td>" . $row['views'] . "</td>
                                    <td>" . $row['rating'] . "</td>
                                </tr>
                            ";
                        }
                    } 

                    $conn->close();
                ?>
            </table>
        </div>

        <div class="fading-screen"></div>
        
        <!-- Include here some other HTML files -->
        <div w3-include-html="html/utils/background.html"></div>
    </body>

    <script src="js/utils/includeHTML.js"></script>
    <script>
        includeHTML();
    </script>

</html>
