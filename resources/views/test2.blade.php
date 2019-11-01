

<table class="row section">
    <tr>
        <td class="section__cell">
            <center>
                <table class="container">
                    <tr>
                        <td>
                            <h3>Customer information</h3>
                        </td>
                    </tr>
                </table>
                <table class="container">
                    <tr>
                        <td>
                            <table class="row">
                                <tr>
                                    <td class="customer-info__item">
                                        <h4>Future Ship-Out-Date</h4>
                                        <p>{{\Carbon\Carbon::parse($order->ship_out_date)->format('Y-m-d')}}</p>
                                    </td>
                                </tr>
                                <tr>
                                  @if($order->has_recepient != null)
                                    <td class="customer-info__item">
                                        <h4>Shipping address</h4>
                                        <p>{{$order->has_recepient->firstname}} {{$order->has_recepient->last_name}}</p>
                                        <br>
                                        <p>{{$order->has_recepient->business}}</p><br>
                                        <p>{{$order->has_recepient->address1}}</p><br>
                                        <p>{{$order->has_recepient->address2}}</p><br>
                                        <p>{{$order->has_recepient->city}}, {{$order->has_recepient->state}} {{$order->has_recepient->postcode}}</p>
                                        <br>
                                        <p>{{$order->has_recepient->country}}</p>
                                    </td>
                                    @endif

                                    @if($order->has_billing != null)
                                          <td class="customer-info__item">
                                        <h4>Billing address</h4>
                                              <p>{{$order->has_billing->firstname}} {{$order->has_billing->last_name}}</p>
                                              <br>
                                              <p>{{$order->has_billing->business}}</p><br>
                                              <p>{{$order->has_billing->address1}}</p><br>
                                              <p>{{$order->has_billing->address2}}</p><br>
                                              <p>{{$order->has_billing->city}} {{$order->has_billing->state}} {{$order->has_billing->postcode}}</p>
                                              <br>
                                              <p>{{$order->has_billing->country}}</p>
                                    </td>
                                        @endif

                                </tr>
                            </table>
                            <table class="row">
                                <tr>
                                    @if($order->shipping_method_title != null)
                                        <td class="customer-info__item">
                                        <h4>Shipping method</h4>
                                        <p>{{$order->shipping_method_title}}</p>
                                    </td>
                                    @endif
                                        @if($order->payment_gateway != null)
                                    <td class="customer-info__item">
                                        <h4>Payment method</h4>
                                        <p class="customer-info__item-content">
                                            {{$order->payment_gateway}} - ${{number_format($order->order_total,2)}} USD
                                        </p>
                                    </td>
                                            @endif
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>


