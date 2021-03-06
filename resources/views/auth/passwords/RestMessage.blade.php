<!DOCTYPE html>
<html>
    <head>
        <title>Education Engineer Verification Email adderess</title>
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/assets.css')}}">

        <!-- TYPOGRAPHY ============================================= -->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/typography.css')}}">

        <!-- SHORTCODES ============================================= -->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/shortcodes/shortcodes.css')}}">

        <!-- STYLESHEETS ============================================= -->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
        <link class="skin" rel="stylesheet" type="text/css" href="{{asset('assets/css/color/color-1.css')}}"/>
    </head>
    <body  class="section-area section-sp2 bg-fix  join-bx text-center" >
        <div  class="section-area section-sp2 bg-fix  join-bx text-center" >
            <div  class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="join-content-bx text-white">
                            <h2 style="color:black">Thank you 
                                <?php if ($user): ?>
                                    <?= $user->firstname . ' ' . $user->lastname ?>
                                <?php endif; ?>
                                <br/></h2>
                            <div class="mw800 m-auto">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="cours-search-bx m-b30">
                                            <div class="icon-box">
                                                <h3 style="color:black"><i class="ti-user"></i><span class="counter"></span>Message</h3>
                                            </div>
                                            <span style="color:black" class="cours-search-text">
                                                <?= $message?>
                                                   <?php if ($user): ?>
                                                    <?= $user->email ?>
                                                <?php endif; ?> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section-sp2">
                                <?php if($is_found==0):?>
                                <a href="{{route('user.forgetpassword')}}" class="btn button-md">Enter a Valid Email</a>
                                <a href="{{(route('register_user') )}}" class="btn button-md">Registration</a>
                                <?php elseif($is_found==1) : ?>
                                <a href="{{(route('indexeco') )}}" class="btn button-md">Home</a>
                                <?php elseif($is_found==2) : ?>
                                <a href="{{route('indexeco')}}" class="btn button-md">Home</a>
                                <?php endif;?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About Content END ==== -->

    </body>
</html>

