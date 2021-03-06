


// Immediately-invoked function expression
(function() {
    // Load the script
    var script = document.createElement("SCRIPT");
    script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js';
    script.type = 'text/javascript';
    script.onload = function() {
        var $ = window.jQuery;
        $(document).ready(function() {

            $('body').find('.product__description__property').hide();

                var APP_URL = "https://postdelay.shopifyapplications.com";

            // var APP_URL ="http://127.0.0.1:8000"

            var orderDetails = Shopify.checkout;
            let response;
            console.log(orderDetails);
            if(orderDetails != null ){
                var shopifyorderid = orderDetails.order_id;

                var checkouttoken = orderDetails.token;
                var shopdomain = Shopify.shop;
                var line_items = orderDetails.line_items;

                $.each(line_items,function (key,item) {
                    if(item.title === 'PostDelay Additional Fee'){
                        var properties = item.properties;
                        $.each(properties,function (key,value) {
                            if(key === 'Response'){
                             response = value;
                            }
                        })
                    }
                });

            }


            $('.step__sections > .section > .section__content > .content-box:first-child').hide();
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
                                  "                <p class='Custom-message-desp'>Your order has been received and payment was successful </p><br>\n" +
                                  "                <p class='Custom-message-desp'><a href='https://postdelay.shopifyapplications.com/download/pdf?order="+ shopifyorderid +"'>  Print out this form</a> and include it in your shipment to us </p>\n" +
                                  "                <p class='Custom-message-desp'>if you don't have a printer and would like the form mailed to you </p>\n" +
                                  "                <p class='Custom-message-desp'>Instead this service is available for $1.00</p>\n" +
                                  "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=request-form&&order-id="+shopifyorderid+"'>Click here</a> to request a paper & copy of the form </p><br>\n" +
                                  "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=existing-orders'>Click here</a> to view the details of your order</p>\n" +
                                  "              </div>\n" +
                                  "            </div>\n" +
                                  "          </div>\n" +
                                  "        </div>\n"+
                                  "  </div>\n" +
                                  "</div> ");

                          }
                      }
                      else if(data.type === 0){
                          if ($('body .section__content').length > 0) {
                              if(response === '9'){
                                  $(".section__content .content-box").eq(0).after("<div class='content-box'>\n" +
                                      "  <div class='content-box__row text-container'>\n" +
                                      " <h2 class='heading-2 os-step__title' id='main-header' tabindex='-1' >Your Payment Has Been Received </h2>\n" +
                                      "        <div class='page-width-1'> \n" +
                                      "          <div class='Form-wraper'> \n" +
                                      "            <div class='Form-contaner'> \n" +
                                      "              <div class='Custom-message'>\n" +
                                      "                <p class='Custom-message-desp'><b>What's Next?</b> PostDelay will send your item back to you on the next business day.</p>\n" +
                                      "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=existing-orders'>Click here</a> to view the details of your order</p>\n" +
                                      "              </div>\n" +
                                      "            </div>\n" +
                                      "          </div>\n" +
                                      "        </div>\n"+
                                      "  </div>\n" +
                                      "</div> ");
                              }
                              else if(response === '20'){
                                  $(".section__content .content-box").eq(0).after("<div class='content-box'>\n" +
                                      "  <div class='content-box__row text-container'>\n" +
                                      " <h2 class='heading-2 os-step__title' id='main-header' tabindex='-1' >Your Payment Has Been Received </h2>\n" +
                                      "        <div class='page-width-1'> \n" +
                                      "          <div class='Form-wraper'> \n" +
                                      "            <div class='Form-contaner'> \n" +
                                      "              <div class='Custom-message'>\n" +
                                      "                <p class='Custom-message-desp'><b>What's Next?</b> PostDelay will re-send your item on the next business day.</p>\n" +
                                      "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=existing-orders'>Click here</a> to view the details of your order</p>\n" +
                                      "              </div>\n" +
                                      "            </div>\n" +
                                      "          </div>\n" +
                                      "        </div>\n"+
                                      "  </div>\n" +
                                      "</div> ");
                              }
                              else if(response === '21'){
                                  $(".section__content .content-box").eq(0).after("<div class='content-box'>\n" +
                                      "  <div class='content-box__row text-container'>\n" +
                                      " <h2 class='heading-2 os-step__title' id='main-header' tabindex='-1' >Your Payment Has Been Received </h2>\n" +
                                      "        <div class='page-width-1'> \n" +
                                      "          <div class='Form-wraper'> \n" +
                                      "            <div class='Form-contaner'> \n" +
                                      "              <div class='Custom-message'>\n" +
                                      "                <p class='Custom-message-desp'><b>What's Next?</b> PostDelay will send your item back to you on the next business day.</p>\n" +
                                      "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=existing-orders'>Click here</a> to view the details of your order</p>\n" +
                                      "              </div>\n" +
                                      "            </div>\n" +
                                      "          </div>\n" +
                                      "        </div>\n"+
                                      "  </div>\n" +
                                      "</div> ");
                              }
                              else if(response === '16'){
                                  $(".section__content .content-box").eq(0).after("<div class='content-box'>\n" +
                                      "  <div class='content-box__row text-container'>\n" +
                                      " <h2 class='heading-2 os-step__title' id='main-header' tabindex='-1' >Your Payment Has Been Received </h2>\n" +
                                      "        <div class='page-width-1'> \n" +
                                      "          <div class='Form-wraper'> \n" +
                                      "            <div class='Form-contaner'> \n" +
                                      "              <div class='Custom-message'>\n" +
                                      "                <p class='Custom-message-desp'><b>What's Next?</b> PostDelay will continue with your shipment on its scheduled date.</p>\n" +
                                      "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=existing-orders'>Click here</a> to view the details of your order</p>\n" +
                                      "              </div>\n" +
                                      "            </div>\n" +
                                      "          </div>\n" +
                                      "        </div>\n"+
                                      "  </div>\n" +
                                      "</div> ");
                              }
                              else if(response === '17'){
                                  $(".section__content .content-box").eq(0).after("<div class='content-box'>\n" +
                                      "  <div class='content-box__row text-container'>\n" +
                                      " <h2 class='heading-2 os-step__title' id='main-header' tabindex='-1' >Your Payment Has Been Received </h2>\n" +
                                      "        <div class='page-width-1'> \n" +
                                      "          <div class='Form-wraper'> \n" +
                                      "            <div class='Form-contaner'> \n" +
                                      "              <div class='Custom-message'>\n" +
                                      "                <p class='Custom-message-desp'><b>What's Next?</b> PostDelay will send your item back to you on the next business day.</p>\n" +
                                      "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=existing-orders'>Click here</a> to view the details of your order</p>\n" +
                                      "              </div>\n" +
                                      "            </div>\n" +
                                      "          </div>\n" +
                                      "        </div>\n"+
                                      "  </div>\n" +
                                      "</div> ");
                              }
                              else{
                                  $(".section__content .content-box").eq(0).after("<div class='content-box'>\n" +
                                      "  <div class='content-box__row text-container'>\n" +
                                      " <h2 class='heading-2 os-step__title' id='main-header' tabindex='-1' >Your Payment Has Been Received </h2>\n" +
                                      "        <div class='page-width-1'> \n" +
                                      "          <div class='Form-wraper'> \n" +
                                      "            <div class='Form-contaner'> \n" +
                                      "              <div class='Custom-message'>\n" +
                                      "                <p class='Custom-message-desp'><b>What's Next?</b> PostDelay will send your shipping label to you on the next business day.</p>\n" +
                                      "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=existing-orders'>Click here</a> to view the details of your order</p>\n" +
                                      "              </div>\n" +
                                      "            </div>\n" +
                                      "          </div>\n" +
                                      "        </div>\n"+
                                      "  </div>\n" +
                                      "</div> ");
                              }
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
                                  "                <p class='Custom-message-desp'>Your order has been received and payment was successful </p><br>\n" +
                                  "                <p class='Custom-message-desp'><a href='https://postdelay.shopifyapplications.com/download/pdf?order="+ shopifyorderid +"'>  Print out this form</a> and include it in your shipment to us </p>\n" +
                                  "                <p class='Custom-message-desp'>if you don't have a printer and would like the form mailed to you </p>\n" +
                                  "                <p class='Custom-message-desp'>Instead this service is available for $1.00</p>\n" +
                                  "                <p class='Custom-message-desp'><a href='https://postdelay.myshopify.com/account?view=request-form&&order-id="+shopifyorderid+"'>Click here</a> to request a paper & copy of the form </p><br>\n" +
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

        });
    };
    document.getElementsByTagName("head")[0].appendChild(script);
})();





