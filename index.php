<?php
  require_once('./lib/Braintree.php');

    // Force SSL connection
    if (!isset($_SERVER['HTTPS'])){
        header('Location: https://www.conquermaths.com/signup-bt/git/index.php');
    }
  
    Braintree_Configuration::environment('sandbox');
    Braintree_Configuration::merchantId('83cr4qfg7cpdm32v');
    Braintree_Configuration::publicKey('hfmqcdgkrxxb4b6w');
    Braintree_Configuration::privateKey('9a58840d9a2f377d3ce31557dbbedc87');

    $clientToken = Braintree_ClientToken::generate();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hosted fields v3 3D Secure</title>
        <link rel="stylesheet" type="text/css" href="css/braintree.css">
    </head>
    <body translate="no">
        <!--[if IE 9]>
        <style>
        
        header {
          margin-top: 1em;
          text-align: center;
        }
        
        #my-sample-form {
          margin: 0 auto;
          padding-top: 2em;
        }
        
        .bg-illustration {
          z-index: -1;
        }
        
        #button-pay {
          margin: 1em auto 0;
          display: block;
        }
        
        .cardinfo-exp-date, .cardinfo-cvv {
          width: 45%;
          float: left;
        }
        
        .cardinfo-wrapper {
          overflow: hidden;
        }
        
        </style>
        <![endif]-->


        <form action="ProcessTransaction.php" id="submitForm" method="post" ><br>
            <label for='item'>Item:</label><br>
            <input type="text" name="item" value="Buying a new phone" /><br>
            <label for='amount'>Price:</label><br>
            <input id="price" type="text" name="amount" value="100.00" /><br>
            <label for='fname'>Name:</label><br>
            <input type="text" name="firstName" value="Sergio" /><br>
            <label for='lname'>Last Name:</label><br>
            <input type="text" name="lastName" value="Vilaseco-Romero" /><br>
            <label for='streetAddress'>Street:</label><br>
            <input type="text" name="streetAddress" value="24 my street" /><br>
            <label for='locality'>Town:</label><br>
            <input type="text" name="locality" value="My Town" /><br>
            <label for='postalCode'>Postcode:</label><br>
            <input type="text" name="postalCode" value="ABC DE" /><br>
            <label for='region'>County:</label><br>
            <input type="text" name="region" value="Louth" /><br>
            <label for='country'>Country</label><br>
            <input type="text" name="country" value="Ireland" /><br>
            <label for='email'>Email</label><br>
            <input type="text" name="email" value="test@test.com" /><br>
            <label for='phone'>Phone</label><br>
            <input type="text" name="phone" value="0857894512" /><br>
            <label for='website'>Site</label><br>
            <input type="text" name="website" value="www.example.com" /><br>
            <input type='hidden' id="nonce" name='nonce' value=''/>
            <input type="hidden" name="action" value="ccauthorization" />
            <br><br>

        </form>
        <div class="form-container">
            <header>
                <h1>Payment Method</h1>
            </header>

            <form id="my-sample-form" class="scale-down" data-token='<?php echo $clientToken; ?>'>
                <div class="cardinfo-card-number">
                    <label class="cardinfo-label" for="card-number">Card Number</label>
                    <div class='input-wrapper' id="card-number"></div>
                    <div id="card-image"></div>
                </div>

                <div class="cardinfo-wrapper">
                    <div class="cardinfo-exp-date">
                        <label class="cardinfo-label" for="expiration-date">Valid Thru</label>
                        <div class='input-wrapper' id="expiration-date"></div>
                    </div>

                    <div class="cardinfo-cvv">
                        <label class="cardinfo-label" for="cvv">CVV</label>
                        <div class='input-wrapper' id="cvv"></div>
                    </div>

                    <div class="cardinfo-zip">
                        <label class="cardinfo-label" for="postal-code" id="postal-code-label">PostCode</label>
                        <!--  Hosted Fields div container -->
                        <div class="input-wrapper" id="postal-code"></div>
                    </div>

                </div>
            </form>

            <input id="button-pay" type="submit" value="Continue" />
        </div>
        <div id="fade" class="overlay"></div>
        <div id="light" class="modal">
            <div id="toappend">
                <h2>
                    3D Secure verification.
                    <a id='modal-dismiss' href="javascript:void(0)">X</a>
                </h2>
            </div>
        </div>

        <!-- Load the required client component. -->
        <script src="https://js.braintreegateway.com/web/3.6.0/js/client.min.js"></script>
        <!-- Load Hosted Fields component. -->
        <script src="https://js.braintreegateway.com/web/3.6.0/js/hosted-fields.min.js"></script>
        <!-- Load the 3D Secure component. -->
        <script src="https://js.braintreegateway.com/web/3.6.0/js/three-d-secure.min.js"></script>
        <!-- Load jQuery. -->
        <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
        <!-- Load implementation JS. -->
        <script src="js/braintree.js"></script>
    </body>
</html>
