<!doctype html5>
<html>
    <head>
        <title>[natural-selection]</title>
        <link href="css/welcome.css" rel="stylesheet" type="text/css" />
        <link href="css/buttons.css" rel="stylesheet" type="text/css" />
        <link href="css/images.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>		
    </head>
    <body>
        <div w3-include-html="html/header.html"></div>

        <div id="content">
            <div id="a1">
                <div class="header" id="header">
                    <span class="text">
                        Who is the most beautiful for you?
                    </span>
                </div> 

                <div width=100% align=center>
                    <button class="btn-pill" onclick="go_next_screen()">
                        <span>Start</span>
                    </button>
                </div>
            </div>

            <!-- <div class="screen">
                <div class="image left-image" onclick="go_next_screen()"></div>
                <div class="image right-image" onclick="go_next_screen()"></div>

                <div class="name left-name">Olha Kovalenka</div>
                <div class="name right-name">Lesia Ukrainka</div>
            </div> -->
        </div>

        <!-- <div class="skip-button">
            <button class="btn-pill" onclick="go_next_screen()">
                <span>Skip</span>
            </button>
        </div> -->

        <div class="fading-screen"></div>
        
        <!-- Include here some other HTML files -->
        <div w3-include-html="html/utils/background.html"></div>
    </body>

    <script src="js/utils/includeHTML.js"></script>
    <script src="js/welcome/animations.js"></script>
    <script>
        includeHTML();
    </script>

</html>
