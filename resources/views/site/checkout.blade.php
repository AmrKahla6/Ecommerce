@extends('site.layout.app')
@section('title') {{__('site.home')}}  @endsection
@section('content')

<?php 
    $title=trans('all_products.Shop Page'); 
?>
       <!-- Start Bradcaump area -->
       @include('site.components.bradcaump', ['title' =>$title  , 'image' =>  route('image_show', \App\Coverpages::first()->cover_shop) ])
        <!-- End Bradcaump area -->
        <!-- Start Checkout Area -->
        <section class="our-checkout-area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="checkout-right-sidebar">
                            <div class="our-important-note">
                                <h2 class="section-title-3 text_right">Note :</h2>
                                <p class="note-desc text_right">Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut laborekf et dolore magna aliqua.</p>
                                <ul class="important-note">
                                    <li class="text_right"><a href="#">Lorem ipsum dolor sit amet, consectetur nipabali</a></li>
                                    <li class="text_right"><a href="#">Lorem ipsum dolor sit amet</a></li>
                                    <li class="text_right"><a href="#">Lorem ipsum dolor sit amet, consectetur nipabali</a></li>
                                    <li class="text_right"><a href="#">Lorem ipsum dolor sit amet, consectetur nipabali</a></li>
                                    <li class="text_right"><a href="#">Lorem ipsum dolor sit amet</a></li>
                                </ul>
                            </div>
                            <div class="puick-contact-area mt--60">
                                <h2 class="section-title-3">Quick Contract</h2>
                                <a href="phone:+8801722889963">+88 01900 939 500</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-8">
                    <form id="columnarForm" method="post">
                    @csrf
                    <input type="hidden" name="billing_total" value="{{ $total }}" >
                        <div class="ckeckout-left-sidebar">
                            <!-- Start Checkbox Area -->
                            <div class="checkout-form">
                                <h2 class="section-title-3 text_right">Billing details</h2>
                                <div class="checkout-form-inner">
                                    <div class="single-checkout-box">
                                        <input type="text" name="billing_first_name" value="{{ old('billing_name') ? old('billing_name') : $user->name }}" placeholder="First Name*">
                                        <input type="text" name="billing_last_name" value="{{ old('billing_name') ? old('billing_name') : $user->last_name }}" placeholder="Last Name*">
                                    </div>
                                    <div class="single-checkout-box">
                                        <input type="email" name="billing_email" value="{{ old('billing_email') ? old('billing_email') : $user->email }}" placeholder="Emil*">
                                        <input type="text" name="billing_phone" value="{{ old('billing_phone') ? old('billing_phone') : $user->phone }}" placeholder="Phone*">
                                    </div>
                                    <div class="single-checkout-box">
                                        <input type="text" name="billing_city" value="{{ old('billing_city') ? old('billing_city') : $user->city }}" placeholder="city*">
                                        <input type="text" name="billing_province" value="{{ old('billing_province') ? old('billing_province') : $user->province }}" placeholder="province*">
                                    </div>
                                    <div class="single-checkout-box">
                                        <textarea name="billing_address" placeholder="address*">{{ old('billing_address') ? old('billing_address') : $user->address }}</textarea>
                                    </div>                                  
                                    <div class="single-checkout-box checkbox">
                                        <input id="remind-me" name="is_edit" type="checkbox">
                                        <label for="remind-me"><span></span>Update Your a Account ?</label>
                                    </div>
                                </div>                             
                            </div>
                            <!-- End Checkbox Area -->
                         
                              <button type="submit" onclick="submitForm({{ url('') }})"  class="button-primary full-width" style="
                              border-style: none;
                              cursor: pointer;
                              font-size: 14px;
                              line-height: 1.6;
                              background: #3EBFA4;
                              color: white !important;
                              padding: 10px;
                              width: 31%;
                              margin-top:10px
                              ">Pay With Card</button>
                                <button onclick="submitForm('{{route('cash_on_delevery')}}')" class="button-primary full-width" style="
                                border-style: none;
                                cursor: pointer;
                                font-size: 14px;
                                line-height: 1.6;
                                background: #3EBFA4;
                                color: white !important;
                                padding: 10px;
                                width: 37%;
                                margin-top:10px;
                                overflow:hidden
                                ">Cash on Delevery</button>
                            <button type="submit" onclick="submitForm('{{route('paypal')}}')" class="button-primary full-width" style="
                            border-style: none;
                            cursor: pointer;
                            font-size: 14px;
                            line-height: 1.6;
                            background: #3EBFA4;
                            color: white !important;
                            padding: 10px;
                            width: 30%;
                            margin-top:10px
                            ">Pay Paypal</button>
                        
                            <!-- End Payment Box -->
                            <!-- Start Payment Way -->
                   
                            <!-- End Payment Way -->
                        </div>
                </form>
          
                    </div>
                  
                </div>
            </div>
        </section>

        @endsection
@section('js')
<script>
     console.log("submit")
    function submitForm(action)
    {
        console.log("submit")
      
        document.getElementById('columnarForm').action = action;
        document.getElementById('columnarForm').submit();
    }
</script>
@endsection