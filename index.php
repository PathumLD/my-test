<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Stadia </title>
    
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- Stripe JavaScript library -->
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

   </head>

        
    <body>

                <h1>Charge $55 with Stripe</h1>

            <!-- display errors returned by createToken -->
            <span class="payment-errors"></span>

            <!-- stripe payment form -->
            <form action="submit.php" method="POST" id="paymentFrm">
                <p>
                    <label>Name</label>
                    <input type="text" name="name" size="50" />
                </p>
                <p>
                    <label>Email</label>
                    <input type="text" name="email" size="50" />
                </p>
                <p>
                    <label>Card Number</label>
                    <input type="text" name="card_num" size="20" autocomplete="off" 
            class="card-number" />
                </p>
                <p>
                    <label>CVC</label>
                    <input type="text" name="cvc" size="4" autocomplete="off" class="card-cvc" />
                </p>
                <p>
                    <label>Expiration (MM/YYYY)</label>
                    <input type="text" name="exp_month" size="2" class="card-expiry-month"/>
                    <span> / </span>
                    <input type="text" name="exp_year" size="4" class="card-expiry-year"/>
                </p>
                <button type="submit" id="payBtn">Submit Payment</button>
            </form>

    </body>

</html>

            <script type="text/javascript">
            //set your publishable key
            Stripe.setPublishableKey('Your_API_Publishable_Key');

            //callback to handle the response from stripe
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    //enable the submit button
                    $('#payBtn').removeAttr("disabled");
                    //display the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {
                    var form$ = $("#paymentFrm");
                    //get token id
                    var token = response['id'];
                    //insert the token into the form
                    form$.append("<input type='hidden' name='stripeToken' value='" 
            + token + "' />");
                    //submit form to the server
                    form$.get(0).submit();
                }
            }
            $(document).ready(function() {
                //on form submit
                $("#paymentFrm").submit(function(event) {
                    //disable the submit button to prevent repeated clicks
                    $('#payBtn').attr("disabled", "disabled");
                    
                    //create single-use token to charge the user
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                    
                    //submit from callback
                    return false;
                });
            });
            </script>