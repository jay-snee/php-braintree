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
        

        <style>
            /*--------------------
		      Shared Variables
		      --------------------*/
            /*--------------------
            General
            --------------------*/
            html,
            body {
                font-size: 100%;

                font-family: sans-serif;
                padding: 0;
                margin: 0;
            }

            header {
                z-index: 2;
                -webkit-transform: translate(0, 5.5em);
                transform: translate(0, 5.5em);
                -webkit-transition: all .5s ease;
                transition: all .5s ease;
            }
            header.header-slide {
                -webkit-transform: translate(0, 0);
                transform: translate(0, 0);
            }

            h1 {
                font-weight: 100;
                font-size: 1.4em;
                display: block;
            }

            .form-container {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                background-color: #EEE;
                -webkit-box-pack: center;
                -webkit-justify-c-ontent: center;
                -ms-flex-pack: center;
                justify-content: center;
                -webkit-box-align: center;
                -webkit-align-items: center;
                -ms-flex-align: center;
                align-items: center;
                height: 100%;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -webkit-flex-direction: column;
                -ms-flex-direction: column;
                flex-direction: column;
                border: 1em solid #fff;
                box-sizing: border-box;
                position: relative;
            }
            @media (max-width: 476px) {
                .form-container {
                    border: none;
                }
            }

            .cardinfo-wrapper {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-justify-content: space-around;
                -ms-flex-pack: distribute;
                justify-content: space-around;
            }

            .bg-illustration {
                position: absolute;
                bottom: 0;
                left: 0;
                z-index: 0;
            }
            .bg-illustration svg {
                width: 100%;
            }

            .card-shape, #my-sample-form.visa, #my-sample-form.master-card, #my-sample-form.maestro, #my-sample-form.american-express, #my-sample-form.discover, #my-sample-form.unionpay, #my-sample-form.jcb, #my-sample-form.diners-club {
                border-radius: 6px;
                padding: 2em 2em 1em;
            }
            @media (max-width: 476px) {
                .card-shape, #my-sample-form.visa, #my-sample-form.master-card, #my-sample-form.maestro, #my-sample-form.american-express, #my-sample-form.discover, #my-sample-form.unionpay, #my-sample-form.jcb, #my-sample-form.diners-club {
                    padding: 2em 1.5em 1em;
                }
            }

            #my-sample-form {
                background-color: #FFF;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12);
                padding: 8em 3em 2em;
                width: 20em;
                margin-bottom: 2em;
                -webkit-transition: all 600ms cubic-bezier(0.2, 1.3, 0.7, 1);
                transition: all 600ms cubic-bezier(0.2, 1.3, 0.7, 1);
                -webkit-animation: cardIntro 500ms cubic-bezier(0.2, 1.3, 0.7, 1);
                animation: cardIntro 500ms cubic-bezier(0.2, 1.3, 0.7, 1);
                z-index: 1;
            }
            #my-sample-form:hover {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
            }
            @media (max-width: 476px) {
                #my-sample-form {
                    box-sizing: border-box;
                    padding: 7em 2em 2em;
                    width: 100%;
                }
            }
            #my-sample-form.visa {
                color: #fff;
                background-color: #0D4AA2;
            }
            #my-sample-form.master-card {
                color: #fff;
                background-color: #363636;
                background: -webkit-linear-gradient(335deg, #d82332, #d82332 50%, #f1ad3d 50%, #f1ad3d);
                background: linear-gradient(115deg, #d82332, #d82332 50%, #f1ad3d 50%, #f1ad3d);
            }
            #my-sample-form.maestro {
                color: #fff;
                background-color: #363636;
                background: -webkit-linear-gradient(335deg, #009ddd, #009ddd 50%, #ed1c2e 50%, #ed1c2e);
                background: linear-gradient(115deg, #009ddd, #009ddd 50%, #ed1c2e 50%, #ed1c2e);
            }
            #my-sample-form.american-express {
                color: #fff;
                background-color: #007CC3;
            }
            #my-sample-form.discover {
                color: #fff;
                background-color: #ff6000;
                background: -webkit-linear-gradient(#d14310, #f7961e);
                background: linear-gradient(#d14310, #f7961e);
            }
            #my-sample-form.unionpay, #my-sample-form.jcb, #my-sample-form.diners-club {
                color: #fff;
                background-color: #363636;
            }

            .cardinfo-label {
                display: block;
                font-size: 11px;
                margin-bottom: 0.5em;
                text-transform: uppercase;
            }

            .cardinfo-exp-date {
                margin-right: 1em;
                width: 100%;
            }

            .cardinfo-cvv .postal-code{
                width: 100%;
            }

            #postal-code{
                margin-left: 10px;
            }

            #button-pay {
                cursor: pointer;
                width: 16em;
                font-size: 15px;
                border: 0;
                padding: 1.2em 1em;
                color: #fff;
                background: #282c37;
                border-radius: 4px;
                z-index: 0;
                -webkit-transform: translateY(-100px);
                transform: translateY(-100px);
                -webkit-transition: all 500ms cubic-bezier(0.2, 1.3, 0.7, 1);
                transition: all 500ms cubic-bezier(0.2, 1.3, 0.7, 1);
                opacity: 0;
                -webkit-appearance: none;
            }
            #button-pay:hover {
                background: #535b72;
            }
            #button-pay:active {
                -webkit-animation: cardIntro 200ms cubic-bezier(0.2, 1.3, 0.7, 1);
                animation: cardIntro 200ms cubic-bezier(0.2, 1.3, 0.7, 1);
            }
            #button-pay.show-button {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 1;
            }

            .cardinfo-card-number {
                position: relative;
            }

            #card-image {
                position: absolute;
                top: 2em;
                right: 1em;
                width: 44px;
                height: 28px;
                background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/346994/card_sprite.png);
                background-size: 86px 458px;
                border-radius: 4px;
                background-position: -100px 0;
                background-repeat: no-repeat;
                margin-bottom: 1em;
            }
            #card-image.visa {
                background-position: 0 -398px;
            }
            #card-image.master-card {
                background-position: 0 -281px;
            }
            #card-image.american-express {
                background-position: 0 -370px;
            }
            #card-image.discover {
                background-position: 0 -163px;
            }
            #card-image.maestro {
                background-position: 0 -251px;
            }
            #card-image.jcb {
                background-position: 0 -221px;
            }
            #card-image.diners-club {
                background-position: 0 -133px;
            }

            /*--------------------
            Inputs 
            --------------------*/
            .input-wrapper {
                border-radius: 2px;
                background: rgba(255, 255, 255, 0.86);
                height: 2.75em;
                border: 1px solid #eee;
                box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.06);
                padding: 5px 10px;
                margin-bottom: 1em;
            }

            .cardinfo-card-number,
            .cardinfo-exp-date,
            .cardinfo-cvv .postal-code{
                -webkit-transition: -webkit-transform 0.3s;
                transition: -webkit-transform 0.3s;
                transition: transform 0.3s;
                transition: transform 0.3s, -webkit-transform 0.3s;
            }

            .braintree-hosted-fields-focused {
                border-color: #5db6e8;
            }

            .braintree-hosted-fields-invalid {
                border-color: #E53A40;
                -webkit-animation: shake 500ms cubic-bezier(0.2, 1.3, 0.7, 1) both;
                animation: shake 500ms cubic-bezier(0.2, 1.3, 0.7, 1) both;
                -webkit-transform: translate3d(0, 0, 0);
                transform: translate3d(0, 0, 0);
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
                -webkit-perspective: 1000px;
                perspective: 1000px;
            }

            /*--------------------
            Animations
            --------------------*/
            @-webkit-keyframes cardIntro {
                0% {
                    -webkit-transform: scale(0.8) translate(0, 0);
                    transform: scale(0.8) translate(0, 0);
                    opacity: 0;
                }
                100% {
                    -webkit-transform: scale(1) translate(0, 0);
                    transform: scale(1) translate(0, 0);
                    opacity: 1;
                }
            }
            @keyframes cardIntro {
                0% {
                    -webkit-transform: scale(0.8) translate(0, 0);
                    transform: scale(0.8) translate(0, 0);
                    opacity: 0;
                }
                100% {
                    -webkit-transform: scale(1) translate(0, 0);
                    transform: scale(1) translate(0, 0);
                    opacity: 1;
                }
            }
            @-webkit-keyframes shake {
                10%,
                90% {
                    -webkit-transform: translate3d(-1px, 0, 0);
                    transform: translate3d(-1px, 0, 0);
                }
                20%,
                80% {
                    -webkit-transform: translate3d(1px, 0, 0);
                    transform: translate3d(1px, 0, 0);
                }
                30%,
                50%,
                70% {
                    -webkit-transform: translate3d(-3px, 0, 0);
                    transform: translate3d(-3px, 0, 0);
                }
                40%,
                60% {
                    -webkit-transform: translate3d(3px, 0, 0);
                    transform: translate3d(3px, 0, 0);
                }
            }
            @keyframes shake {
                10%,
                90% {
                    -webkit-transform: translate3d(-1px, 0, 0);
                    transform: translate3d(-1px, 0, 0);
                }
                20%,
                80% {
                    -webkit-transform: translate3d(1px, 0, 0);
                    transform: translate3d(1px, 0, 0);
                }
                30%,
                50%,
                70% {
                    -webkit-transform: translate3d(-3px, 0, 0);
                    transform: translate3d(-3px, 0, 0);
                }
                40%,
                60% {
                    -webkit-transform: translate3d(3px, 0, 0);
                    transform: translate3d(3px, 0, 0);
                }
            }

	
      
	/* base semi-transparente */
    .overlay{
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #000;
        z-index:1001;
		opacity:.75;
        -moz-opacity: 0.75;
        filter: alpha(opacity=75);
    }
	
    /* estilo para lo q este dentro de la ventana modal */
    .modal {
        display: none;
        position: absolute;
        top: 25%;
        left: 25%;
        width: 50%;
        height: 50%;
        padding: 16px;
        background: #fff;
		color: #333;
        z-index:1002;
        overflow: auto;
    }
        </style>

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
        <form  action="ProcessTransaction.php" id="submitForm" method="post" style="margin-left: 30px "><br>
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
                        <label class="cardinfo-label" for="postal-code" style="margin-left: 10px">PostCode</label>
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
            var form = document.querySelector('#my-sample-form');
            var submit = document.querySelector('input[type="submit"]');
            braintree.client.create({authorization: '<?php echo $clientToken ?>'}, function (err, clientInstance) {
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
        <div id="fade" class="overlay" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"></div>
        <div id="light" class="modal">
            <div id="toappend">
                
                <h2>3D Secure verification.<a style="float:right" href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">X</a></h2>
            </div>
        </div>

    </body>
</html>
