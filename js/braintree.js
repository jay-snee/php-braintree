// Header Scripts
window.console = window.console || function (t) {};

if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
}

// Inline Scripts

$("#modal-dismiss").on('click', function(event){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';
})

$("#fade").on('click', function(event){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';
})

// Implementation

var form = document.querySelector("#my-sample-form");
var submit = document.querySelector("input[type=\"submit\"]");
braintree.client.create({authorization: $('#my-sample-form').data('token')}, function (err, clientInstance) {
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