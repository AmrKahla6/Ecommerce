 <!-- Start Footer Area -->
 <footer class="htc__foooter__area" style="background: #f5f5f5 url({{ route('image_show', \App\Coverpages::first()->cover_footer) }}) no-repeat scroll center center / cover ;">
            <div class="container">
                <div class="row footer__container clearfix" style="text-align: center">
                    <!-- Start Single Footer Widget -->
                    <div class="col-md-6 col-lg-3  col-sm-12">
                        <div class="ft__widget">
                            <div class="ft__logo">
                                <a href="{{ route('indexeco') }}">
                                <img src="{{ asset('logo.jpg') }}" alt="logo">
                                </a>
                            </div>
                            <div class="footer__details">
                                <p>Email : {{\App\Contactinfo::first()->email}} </p>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Footer Widget -->
                    <!-- Start Single Footer Widget -->
                    <div class="col-md-6 col-lg-3  col-sm-12 smb-30 xmt-30">
                        <div class="ft__widget">
                            <h2 class="ft__title"> {{trans('header.Newsletter')}}</h2>
                            <div class="newsletter__form">
                                <div class="input__box">
                                    <div id="mc_embed_signup">
                                        <form method="POST" action="{{ route('save_subscripe') }}" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" novalidate>
                                        @csrf
                                            <div id="mc_embed_signup_scroll" class="htc__news__inner">
                                                <div class="news__input">
                                                    <input type="email" value="" name="email" class="email" id="mce-EMAIL" placeholder="{{trans('site.Email_Address')}}" required>
                                                </div>
                                                <div class="clearfix subscribe__btn"><input type="submit" value="Send" name="subscribe" id="mc-embedded-subscribe" class="bst__btn btn--white__color">

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Footer Widget -->
                    <!-- Start Single Footer Widget -->
                    <div class="col-md-6 col-lg-3  col-sm-12 smt-30 xmt-30">
                        <div class="ft__widget contact__us">
                            <h2 class="ft__title">{{trans('header.Contact Us')}}</h2>
                            <div class="footer__inner">
                                <p> {{\App\Contactinfo::first()->location}} <br> </p>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Footer Widget -->
                    <!-- Start Single Footer Widget -->
                    <div class="col-md-6 col-lg-2 lg-offset-1 col-sm-12 smt-30 xmt-30" style="text-align: center">
                        <div class="ft__widget">
                            @if($socials = \App\SocialSetting::all())
                            <h2 class="ft__title"> {{trans('header.Follow Us')}}</h2>
                            <ul class="social__icon" style="margin: auto">
                                @foreach($socials as $social)
                                <li><a href="{{ $social->url }}" target="_blank"><i class="zmdi zmdi-{{ $social->icon }}"></i></a></li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                    <!-- End Single Footer Widget -->
                </div>
                <!-- Start Copyright Area -->
                <div class="htc__copyright__area">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="copyright__inner">
                                <div class="copyright">
                                    <p>© 2020 <a href="{{ route('indexeco') }}" target="_blank">Ecommerce Name</a>
                                    All Right Reserved.</p>
                                </div>
                                <ul class="footer__menu">
                                    <li style="padding: 0 5px"><a href="{{ route('indexeco') }}">Home</a></li>
                                    <li style="padding: 0 5px"><a href="{{route('about_index') }}">About</a></li>
                                    <li style="padding: 0 5px"><a href="{{route('contact') }}">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Copyright Area -->
            </div>
        </footer>
        <!-- End Footer Area -->

    <!-- Body main wrapper end -->
    <!-- QUICKVIEW PRODUCT -->
    <div id="quickview-wrapper">
        <!-- Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal__container" role="document">
                <div class="modal-content">
                    <div class="modal-header modal__header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-product">
                            <!-- Start product images -->
                            <div class="product-images">
                                <div id="show_image" class="main-image images">
                                    <img alt="big images" id="product_img" src="{{ asset('front/images/loading.gif') }}">
                                </div>

                                <div style="display:none" id="gif_downloader" class="main-image images">
                                    <iframe src="https://giphy.com/embed/hTrXs1jw6ABY9dDyxS"  frameBorder="0" class="giphy-embed" allowFullScreen></iframe><p></p>
                                </div>
                            </div>
                            <!-- end product images -->
                            <div class="product-info">
                                <h1 id="product_name"> </h1>

                                <div class="price-box-3">
                                    <div class="s-price-box">
                                        <span id="new_price" class="new-price"></span>
                                        <span id="old_price" class="old-price"></span>
                                    </div>
                                </div>
                                <div id="product_desc" class="quick-desc">
                                </div>

                                <div class="select__color">
                                    <h2 id="select_color"></h2>
                                    <ul class="color__list">

                                    </ul>
                                </div>
                                <div class="select__size">
                                    <h2 id="select_size"></h2>
                                    <ul class="color__list">

                                    </ul>
                                </div>

                                <div  class="addtocart-btn"> <a id="show_product" href=""> show product</a> </div>
                            </div><!-- .product-info -->
                        </div><!-- .modal-product -->
                    </div><!-- .modal-body -->
                </div><!-- .modal-content -->
            </div><!-- .modal-dialog -->
        </div>
        <!-- END Modal -->
    </div>
    <!-- END QUICKVIEW PRODUCT -->
    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- jquery latest version -->

    <script src="{{ asset('front/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- Bootstrap Framework js -->
    <script src="{{ asset('front/js/popper.min.js') }}"></script>
    <script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
    <!-- All js plugins included in this file. -->
    <script src="{{ asset('front/js/plugins.js') }}"></script>
    @if(App::getLocale() == 'en')
    <script src="{{ asset('front/js/main.js') }}"></script>
    @else
    <script src="{{ asset('front/js/main_ar.js') }}"></script>
    @endif
    @yield('js')
    <script>
        $(".detail-link").click(function(){
            console.log("oojoj");
            let CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            let id          = $(this).attr("data-id");
            let action      =  "{{route('find_product')}}";
            let indexeco    =  "{{route('indexeco')}}";
            $('.select__size .color__list').empty();
            $('.select__color .color__list').empty();
            $("#select_color").text("");
            $("#select_size").text("");
            $("#product_name").text("");
            $("#product_desc").text("");
            $("#productModal #old_price").text("");
            $("#productModal #new_price").text("");
            $("#product_img").attr("src", "{{ asset('front/images/loading.gif') }}");
            $("#show_product").attr("href", "product-details/"+id+"");
            $.ajax({
                url:  action,
                type: 'POST',
                dataType: 'JSON',
                data: {_token: CSRF_TOKEN, id: id},
                success: function(data, status){

                    let i = 0;
                    let j = 0;
                    let c = 0;
                    for(i; i < data.length; i++) {
                        console.log(data[i].sale)
                        if(data[i].sale != null){
                            console.log(data[i].sale)
                            $("#productModal #old_price").text( data[i].price);
                            $("#productModal #new_price").text( ( (100-data[i].sale) / 100) * data[i].price );
                        }
                        if(!data[i].sale){
                            $("#productModal #new_price").text( data[i].price);
                        }
                        $("#product_img").attr("src", indexeco+ "/images/" +data[i].image);
                        $("#productModal #product_desc").text( data[i].description);
                        $("#productModal #product_name").text( data[i].name);
                        for(j; j < data[i].productsizes.length; j++) {
                            if(j==0){
                                $("#select_size").text("select size");
                            }
                            $('.select__size .color__list').append(`<li class="l__size" ><a  href="#">${data[i].productsizes[j].size}</a></li>`);
                        }
                        for(c; c < data[i].productcolors.length; c++) {
                            $('.select__color .color__list').append(`<li style="background: "+b+" none repeat scroll 0 0;border-radius: 100%; height: 30px; width: 30px;" class="red"><a  style="background: ${data[i].productcolors[c].color} none repeat scroll 0 0;" title="Red" href="#">Red</a></li>`);
                            if(c==0){
                                $("#select_color").text("select color");
                            }
                        }
                    }

                }
            });
        });
    </script>
    <script>
        $(".add_to_cart").click(function(){
            let CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            let product     = $(this).attr("data-id");
            let action      =  "{{route('add_to_cart2')}}";
            $("#cart_"+product).addClass("hide");
            $(".loading_icon_cart_"+product).removeClass("hide");

            $.ajax({
                url:  action,
                type: 'POST',
                dataType: 'JSON',
                data: {_token: CSRF_TOKEN, product: product},
                success: function(data, status){
                    $(".loading_icon_cart_"+product).addClass("hide");
                    $("#cart_"+product).removeClass("hide");
                    $("#none_data_cart").hide();
                    $("#data_cart").show();
                    if(data[1] == 0){
                        console.log($("#quantity_"+data[0]))
                        $("#quantity_"+data[0]).text(data[5]);
                        document.getElementById('price_'+data[0]).innerHTML =data[4];
                        let ttt = parseFloat($("#total__price").text());
                        document.getElementById("total__price").innerHTML =ttt + data[6];
                    }
                    if(data[1] == 1){
                        if(parseFloat($("#total__price").text()) != null){
                            let ttt = parseFloat($("#total__price").text());
                            document.getElementById("total__price").innerHTML =ttt + data[6];
                        }else{
                            document.getElementById("total__price").innerHTML =data[6];
                        }
                        $('#data_cart .shp__cart__wrap_2').append(`
                            <div class="shp__single__product">
                                <div class="shp__pro__thumb">
                                <a href="#">
                                    <img src="${data[3]}" alt="product images">
                                </a>
                            </div>
                            <div class="shp__pro__details shp__pro__details_cart">
                                    <h2><a href="">${data[2]}</a></h2>
                                    <span id="quantity_${data[0]}" class="quantity">${data[5]}</span>
                                    <span id="price_${data[0]}" class="shp__price">${data[4]}</span>
                                </div>
                                <div class="remove__btn">
                                    <a href="#" title="Remove this item"><i class="zmdi zmdi-close"></i></a>
                                </div>
                            </div>
                        `);

                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to cart successfully',
                        showConfirmButton: false,
                        timer: 2500
                    })
                }
            });
        });
    </script>
    <script>
        $(".add__to__wishlist_2 a .ti-heart").click(function(){

            let CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            let product          = $(this).attr("data-id");
            $("#fav_"+product).addClass("hide");
            $(".loading_icon_fav_"+product).removeClass("hide");
            if($(this).hasClass("change_color") ){
                $(this).removeClass("change_color");
                let action      =  "{{route('remove_from_favourite')}}";
                $.ajax({
                    url:  action,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {_token: CSRF_TOKEN, product: product},
                    success: function(data, status){
                        $("#fav_"+product).removeClass("hide");
                        $(".loading_icon_fav_"+product).addClass("hide");
                        console.log(data[1]);
                        if(data[1] == 0){
                            $("#none_data_favourite").show();
                            $("#data_favourite").hide();
                        }else{
                            $("#none_data_favourite").hide();
                            $("#data_favourite").show();
                        }

                        document.getElementById("favourite_"+data[0]).remove();

                        Swal.fire({
                            icon: 'success',
                            title: 'Remove from favourite successfully',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                });
            }else{
                $(this).addClass("change_color");
                $("#none_data_favourite").hide();
                $("#data_favourite").show();

                let action      =  "{{route('add_to_favourite')}}";
                $.ajax({
                    url:  action,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {_token: CSRF_TOKEN, product: product},
                    success: function(data, status){
                        $("#fav_"+product).removeClass("hide");
                        $(".loading_icon_fav_"+product).addClass("hide");
                        $('#shp__cart__wrap').append(`
                            <div id="favourite_${data[0].id}" class="shp__single__product">
                                <div class="shp__pro__thumb">
                                    <a href="#">
                                        <img src="${data[0].photo}" alt="product images">
                                    </a>
                                </div>
                                <div class="shp__pro__details">
                                    <h2><a href="product-details.html">${data[0].name}</a></h2>
                                    <span class="shp__price">${data[0].price} </span>
                                </div>
                                <div data-id="${data[0].id}" class="remove__btn remove__btn_favourite">
                                    <a href="#" title="Remove this item"><i class="zmdi zmdi-close"></i></a>
                                </div>
                            </div>
                        `);
                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Favourite successfully',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                });
            }

        });
    </script>
    <script>
        $(".remove__btn_favourite").click(function(){
            let product     = $(this).attr("data-id")
            let CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            let action      =  "{{route('remove_from_favourite')}}";
            $.ajax({
                url:  action,
                type: 'POST',
                dataType: 'JSON',
                data: {_token: CSRF_TOKEN, product: product},
                success: function(data, status){
                    console.log(data[1]);
                    if(data[1] == 0){
                        $("#none_data_favourite").show();
                        $("#data_favourite").hide();
                    }else{
                        $("#none_data_favourite").hide();
                        $("#data_favourite").show();
                    }
                    document.getElementById("favourite_"+data[0]).remove();
                }
            });
        });
    </script>
</body>

</html>
