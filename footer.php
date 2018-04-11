 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(".toggleForms").click(function(){
            $("#signupForm").toggle();
            $("#loginForm").toggle();

        });

        $('#diary').bind('input propertychange', function() {
            $.ajax({
                type: "POST",
                url: "updatedatabase.php",
                data: { content: $("#diary").val() }
              })
        });       
    </script>

    <!-- <script type="text/javascript">
            $("form").submit(function(e){
                e.preventDefault();

                var error = "";

                if($("#name").val() == ""){
                    error += "<p>the name filed is required</p>";
                }
                if($("#email").val() == ""){
                    error += "<p>the email filed is required</p>";
                }
                if($("#password").val() == ""){
                    error += "<p>the password filed is required</p>";
                }

                if(error !=""){
                    $("#error").html('<div class="alert alert-danger" role="alert"><strong>there were error(s) in your form</strong>' + error +'</div>');
                }else{
                    $("form").unbind("submit").submit();
                }
            });
        </script> -->
        
  </body>
   

</html>