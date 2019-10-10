


// Immediately-invoked function expression
(function() {
    // Load the script
    var script = document.createElement("SCRIPT");
    script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js';
    script.type = 'text/javascript';
    script.onload = function() {
        var $ = window.jQuery;
        $(document).ready(function() {

                var APP_URL = "https://postdelay.shopifyapplications.com";

            // var APP_URL ="http://127.0.0.1:8000"

            var orderDetails = Shopify.checkout;
            var shopifyorderid = orderDetails.order_id;
            var checkouttoken = orderDetails.token;
            var shopdomain = Shopify.shop;

            console.log(orderDetails, shopifyorderid, checkouttoken, shopdomain);
            $.ajax(
                {
                    type:'GET',
                    url:APP_URL+'/get-order',
                    data: {
                        shopify_order_id:shopifyorderid,
                    },
                    success:function(data){
                      if(data.type === 0){
                          if ($('body .section__content').length > 0) {

                              $(".section__content .content-box").eq(0).after("<div class='content-box'>\n" +
                                  "  <div class='content-box__row text-container'>\n" +
                                  " <h2 class='heading-2 os-step__title' id='main-header' tabindex='-1' >PostDelay Message</h2>\n" +
                                  "        <div class='page-width-1'> \n" +
                                  "          <div class='Form-wraper'> \n" +
                                  "            <div class='Form-contaner'> \n" +
                                  "              <div class='Custom-message'>\n" +
                                  "                <p class='Custom-message-desp'>Your order has been received and payment was successful</p>\n" +
                                  "                <p class='Custom-message-desp'>The order ID is "+ shopifyorderid+"</p>\n" +
                                  "                <p class='Custom-message-desp'>In the order for us to link your package with this order,</p>\n" +
                                  "                <p class='Custom-message-desp'><span id='pdf_button' style='border-bottom: #0056b3 1px solid;cursor: pointer;color: #0056b3' data-order='"+ shopifyorderid +"' data-url='https://postdelay.shopifyapplications.com/download/pdf'>  Print out this form</span> and include it in your shipment to us </p>\n" +
                                  "                <p class='Custom-message-desp'>if you don't have a printer and would like the form mailed to you </p>\n" +
                                  "                <p class='Custom-message-desp'>Instead this service is available for $1.00</p>\n" +
                                  "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=request-form&&order-id="+shopifyorderid+"'>Click here</a> to request a paper & copy of the form </p>\n" +
                                  "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=existing-orders'>Click here</a> to view the details of your order</p>\n" +
                                  "              </div>\n" +
                                  "            </div>\n" +
                                  "          </div>\n" +
                                  "        </div>\n"+
                                  "  </div>\n" +
                                  "</div> ");

                          }
                      }
                      else{
                          if ($('body .section__content').length > 0) {

                              $(".section__content .content-box").eq(0).after("<div class='content-box'>\n" +
                                  "  <div class='content-box__row text-container'>\n" +
                                  " <h2 class='heading-2 os-step__title' id='main-header' tabindex='-1' >PostDelay Message</h2>\n" +
                                  "        <div class='page-width-1'> \n" +
                                  "          <div class='Form-wraper'> \n" +
                                  "            <div class='Form-contaner'> \n" +
                                  "              <div class='Custom-message'>\n" +
                                  "                <p class='Custom-message-desp'>Your payment has been received </p>\n" +
                                  "                <p class='Custom-message-desp'>The order ID for this payment is "+ shopifyorderid+"</p>\n" +
                                  "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=existing-orders'>Click here</a> to view the details of your order</p>\n" +
                                  "              </div>\n" +
                                  "            </div>\n" +
                                  "          </div>\n" +
                                  "        </div>\n"+
                                  "  </div>\n" +
                                  "</div> ");

                          }
                      }
                    },
                });

            $('body').on('click','#pdf_button',function () {
               $.ajax({
                   type:'GET',
                   url:$(this).data('url'),
                   data: {
                       order:$(this).data('order'),
                   },
                   success:function (data) {

                   },
               });
            });

        });
    };
    document.getElementsByTagName("head")[0].appendChild(script);
})();





