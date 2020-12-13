<!doctype html5>
<html>
    <head>
        <title>What you prefer?</title>
        <link href="css/welcome.css" rel="stylesheet" type="text/css" />
        <link href="css/buttons.css" rel="stylesheet" type="text/css" />
        <link href="css/images.css" rel="stylesheet" type="text/css" />
        <link href="css/add-girl.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>		
    </head>
    <body>
        <div w3-include-html="html/header.html"></div>

        <div id="content">
            <form class="add-girl-form" id="add-girl-form">
                <div class="add-girl-form-header">
                    Add a new girl to the natural selection
                </div>
                <div class="input-field">
                    <input type="text" id="first-name" placeholder="First name" value="<?php echo (isset($_GET['first_name'])) ? $_GET['first_name'] : ''; ?>" />
                </div>
                <div class="input-field">
                    <input type="text" id="last-name" placeholder="Last name" value="<?php echo (isset($_GET['last_name'])) ? $_GET['last_name'] : ''; ?>" />
                </div>
                <div class="input-field">
                    <input type="text" id="photo-url" placeholder="URL" value="<?php echo (isset($_GET['photo_url'])) ? $_GET['photo_url'] : ''; ?>" />
                </div>
                <div class="input-button">
                    <input type="button" onclick="check_girl();" value="Add this girl" />
                </div>
            </form>

            <div class="check-girl-url" id="check-girl-url">
                <h1>Mean her?</h1>
                <div class="girl-image" id="girl-image"></div>
                <div class="input-button">
                    <input type="button" onclick="girl_checked(false);" value="No" class="no" />
                    <input type="button" onclick="girl_checked(true);" value="Yes" class="yes" />
                </div>
            </div>

            <div class="girl-added-block" id="girl-added-block">
                <div class="girl-added-text">Girl added successfully</div>
                <div class="girl-added-image"></div>
            </div>
        </div>

        <div class="fading-screen"></div>
        
        <!-- Include here some other HTML files -->
        <div w3-include-html="html/utils/background.html"></div>
    </body>

    <script src="js/add_girl/add-girl.js"></script>
    <script src="js/utils/includeHTML.js"></script>
    <script>
        includeHTML();
    </script>

</html>
