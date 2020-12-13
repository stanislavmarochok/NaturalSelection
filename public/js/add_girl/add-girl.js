var url = document.getElementById("photo-url").value;
var first_name = document.getElementById("first-name").value;
var last_name = document.getElementById("last-name").value;

function check_girl()
{
    url = document.getElementById("photo-url").value;
    first_name = document.getElementById("first-name").value;
    last_name = document.getElementById("last-name").value;

    if (first_name == "")
    {
        alert("Enter girl's First name\n");
        return;
    }

    if (last_name == "")
    {
        alert("Enter girl's Last name\n");
        return;
    }

    const cyrillicPattern = /^[\u0400-\u04FF]+$/;
    if(cyrillicPattern.test(first_name) || cyrillicPattern.test(last_name))
    {
        alert("Names should not contain cyrillic");
        return;
    }

    if (url == "")
    {
        alert("Enter girl's photo url\n");
        return;
    }

    if (url != "")
    {
        $.ajax({
            type: "HEAD",
            url : url,
            success: function(message,text,response){
               if(response.getResponseHeader('Content-Type').indexOf("image")!=-1){
                    document.getElementById("girl-image").style.backgroundImage = "url(".concat("'", url, "')");
                    switchPanel();
              } else
              {
                  alertError();
              }
            },
            statusCode: {
                404: function() {
                    alertError();
                },
                403: function() {
                    alertError();
                }
            }
        });
    }
}

function switchPanel()
{
    $('#add-girl-form').addClass("animate__animated animate__fadeOutLeftBig");

    document.getElementById("check-girl-url").style.display = "block";
    $('#check-girl-url').removeClass("animate__animated animate__fadeOutRightBig");
    $('#check-girl-url').addClass("animate__animated animate__fadeInRightBig");
}

function alertError()
{
    alert("URL you provided wasn't recognized as image, press NO and enter a valid URL");
}

function girl_checked(yes)
{
    if (!yes)
    {
        document.getElementById("girl-image").style.backgroundImage = "url('')";
        $('#check-girl-url').addClass("animate__animated animate__fadeOutRightBig");

        document.getElementById("add-girl-form").style.display = "block";
        $('#add-girl-form').removeClass("animate__animated animate__fadeOutLeftBig");
        $('#add-girl-form').addClass("animate__animated animate__fadeInLeftBig");
    } else
    {
        // insert girl to database
        // show successfull block
        $.post( "http://localhost:8000/add-girl", { first_name: first_name, last_name: last_name, photo_url: url }, function (data)
        {
            console.log(data);
            girl_added();
        }).fail(function(){
            alert("Such girl already exists in database, try another URL");
        });
    }
}

function girl_added()
{
    $('#check-girl-url').removeClass("animate__animated animate__fadeInRightBig");
    $('#check-girl-url').addClass("animate__animated animate__fadeOutLeftBig");

    document.getElementById("girl-added-block").style.display = "block";
    $('#girl-added-block').addClass("animate__animated animate__fadeInRightBig");
}