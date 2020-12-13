var current_screen = document.getElementById("a1");
load_next_screen();

function delete_id(id)
{
    // Function not using
    return;

    $.post( "http://localhost:8000/delete-id", { id: id }, function (data)
    {
        console.log(data);
    }).fail(function(){
          console.log("operation failed");
      });
}

function like_id(id)
{
    var current_screen_images = current_screen.children;
    current_screen_images[0].removeAttribute("onclick");
    current_screen_images[1].removeAttribute("onclick");
    
    $.post( "http://localhost:8000/like-id", { id: id }, function (data)
    {

        console.log(data);
    }).fail(function(){
          console.log("operation failed");
      });
}

function go_next_screen()
{
    var previous_screen = current_screen;
    var next_screen = document.getElementById("content").lastElementChild;

    if (next_screen.id != current_screen.id)
    {
        $('#' + current_screen.id).addClass("animate__animated animate__fadeOutUpBig");

        setTimeout(function()
        {
            $('#' + next_screen.id).addClass("animate__animated animate__backInUp");
            next_screen.style.display = "block";
            next_screen.style.zIndex = "2";

            current_screen = next_screen;
            next_screen = load_next_screen();

            var current_screen_images = current_screen.children;
            incrementViews($(current_screen_images[0]).attr('name'));
            incrementViews($(current_screen_images[1]).attr('name'));

            setTimeout(function()
            {
                previous_screen.remove();
            }, 200);
        }, 200);

    } else
    {
        console.log("Next screen not found");
    }
}

function incrementViews(id)
{
    $.post( "http://localhost:8000/increase-view-id", { id: id }, function (data)
    {
        console.log(data);
    }).fail(function(){
          console.log("operation failed");
      });
}

function load_next_screen()
{
    // TODO: get next HTML block with images
    $.post( "http://localhost:8000/get-next-screen", function( data ) {
        addHTML(data);
      }).fail(function(){
          console.log("operation failed");
      });
}

/* 
 * This function creates new screen of images
 */
function addHTML(code)
{
    var new_screen = document.createElement("div");
    new_screen.className = "screen";
    new_screen.setAttribute("id", "a" + (parseInt((current_screen.id).substring(1)) + 1));
    new_screen.innerHTML = code;

    document.getElementById("content").appendChild(new_screen);
}