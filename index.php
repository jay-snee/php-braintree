<?php
  
  require_once('./lib/Braintree.php');
  
  Braintree_Configuration::environment('sandbox');
  Braintree_Configuration::merchantId('83cr4qfg7cpdm32v');
  Braintree_Configuration::publicKey('hfmqcdgkrxxb4b6w');
  Braintree_Configuration::privateKey('9a58840d9a2f377d3ce31557dbbedc87');

  $clientToken = Braintree_ClientToken::generate();
?>


<!DOCTYPE html>
<html >

    <head>
        <meta charset="UTF-8">
        <title>Hosted fields v3 3D Secure</title>
        <link rel="stylesheet" type="text/css" href="css/braintree.css">

        <?php

        $clientToken = Braintree_ClientToken::generate();
        
        // Force SSL connection
        if (!isset($_SERVER['HTTPS'])){
            header('Location: https://www.conquermaths.com/signup-bt/git/index.php');
            //echo "not secure";
        }else{
            //echo "secure";
        }
        ?>
        
        <script>
            window.console = window.console || function (t) {};
        </script>



        <script>
            if (document.location.search.match(/type=embed/gi)) {
                window.parent.postMessage("resize", "*");
            }
        </script>

    </head>

    <body translate="no" >

        <!-- Add animations on Braintree Hosted Fields events -->

        <!-- Card numbers
        4111 1111 1111 1111: Visa
        5555 5555 5555 4444: MasterCard
        3714 496353 98431: American Express
        -->

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

        
        <form  action="ProcessTransaction.php" id="submitForm" method="post" ><br>
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

            <form id="my-sample-form" class="scale-down">
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
            <!--  -->
        </div>

        <!-- Load the required client component. -->
        <script src="https://js.braintreegateway.com/web/3.6.0/js/client.min.js"></script>

        <!-- Load Hosted Fields component. -->
        <script src="https://js.braintreegateway.com/web/3.6.0/js/hosted-fields.min.js"></script>

        <!-- Load the 3D Secure component. -->
        <script src="https://js.braintreegateway.com/web/3.6.0/js/three-d-secure.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.2.1.js"></script>

        <script>
            var form = document.querySelector("#my-sample-form");
            var submit = document.querySelector("input[type=\"submit\"]");
            braintree.client.create({authorization: "<?php echo $clientToken ?>"}, function (err, clientInstance) {
                if (err) {
                    console.error(err);
                    return;
                }
            
                braintree.hostedFields.create({
                    client: clientInstance,
                    styles: {
                        'input': {
                            'color': '#282c37',
                            'font-size': '16px',
                            'transition': 'color 0.1s',
                            'line-height': '3'
                        },
                        'input.invalid': {'color': '#E53A40'},
                        '::-webkit-input-placeholder': {'color': 'rgba(0,0,0,0.6)'},
                        ':-moz-placeholder': {'color': 'rgba(0,0,0,0.6)'},
                        '::-moz-placeholder': {'color': 'rgba(0,0,0,0.6)'},
                        ':-ms-input-placeholder ': {'color': 'rgba(0,0,0,0.6)'}
                    },
                    fields: {
                        number: {
	                       selector: '#card-number',
	                       placeholder: '1111 1111 1111 1111'
	                   },
                        cvv: {
                            selector: '#cvv',
                            placeholder: '123'
                        },
                        expirationDate: {
                            selector: '#expiration-date',
                            placeholder: '10 / 2019'
                        },
                        postalCode: {
                            selector: '#postal-code',
                            placeholder: '90210'
                        }
                    }
                }, function (err, hostedFieldsInstance) {
                    if (err) {
                        console.error(err);
                        return;
                    }

                    var teardown = function (event) {
                        var formValid = Object.keys(event.fields).every(function (key) {
                            return event.fields[key].isValid;
                        });
                        if (formValid) {
                            $('#button-pay').addClass('show-button');
                        } else {
                            $('#button-pay').removeClass('show-button');
                        }
                    };
            
                    hostedFieldsInstance.on('validityChange', teardown);
            
                    hostedFieldsInstance.on('empty', function (event) {
                        $('header').removeClass('header-slide');
                        $('#card-image').removeClass();
                        $(form).removeClass();
                    });

                    hostedFieldsInstance.on('cardTypeChange', function (event) {
                        if (event.cards.length === 1) {
                            $(form).removeClass().addClass(event.cards[0].type);
                            $('#card-image').removeClass().addClass(event.cards[0].type);
                            $('header').addClass('header-slide');
                            
                            if (event.cards[0].code.size === 4) {
                                hostedFieldsInstance.setPlaceholder('cvv', '1234');
                            }
                        } else {
                            hostedFieldsInstance.setPlaceholder('cvv', '123');
                        }
                    });
                    submit.addEventListener('click', function (event) {
                        event.preventDefault();
                        hostedFieldsInstance.tokenize(function (err, payload) {
                            if (err) {
                                console.error(err);
                                return;
                            }
                            var nonce = payload.nonce;

                            // To enable 3D-Secure:
                            // Comment the following lines

                            // nonce = payload.nonce;
                            // document.getElementById("nonce").value = nonce;
                            // document.getElementById("submitForm").submit();

                            // and uncomment the folowing lines
                        
                            var threeDSecure;
                        
                            braintree.threeDSecure.create({
                                client: clientInstance
                            }, function (threeDSecureErr, threeDSecureInstance) {
                            
                                if (threeDSecureErr) {
                            
                                // Handle error in 3D Secure component creation
                                return;
                            }
                        
                            threeDSecure = threeDSecureInstance;
                            var my3DSContainer;
                            threeDSecure.verifyCard({
                                nonce: nonce,
                                amount: document.getElementById('price').value,
                                addFrame: function (err, iframe) {
                                    // Set up your UI and add the iframe.
                                    my3DSContainer = document.createElement('div');
                                    my3DSContainer.appendChild(iframe);
                                    document.getElementById('light').style.display='block';
                                    document.getElementById('fade').style.display='block'
                                    document.getElementById('toappend').appendChild(my3DSContainer);
                                },
                                removeFrame: function () {
                                // Remove UI that you added in addFrame.
                                    document.getElementById('toappend').removeChild(my3DSContainer);
                                }
                            }, function (err, payload) {
                                if (err) {
                                    console.error(err);
                                    return;
                                }

                        	    nonce = payload.nonce;
                                console.log(nonce);
                                document.getElementById("nonce").value = nonce;
                                //document.getElementById("submitForm").submit();
                                });
                            });
                        });
                    }, false);
                });
            });
        </script>
        <div id="fade" class="overlay" onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"></div>
        <div id="light" class="modal">
            <div id="toappend">
                <h2>
                    3D Secure verification.
                    <a id='modal-dismiss' href="javascript:void(0)" onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">X</a>
                </h2>
            </div>
        </div>
    </body>
</html>
