@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
<script src="https://cdn.jsdelivr.net/gh/mathusummut/confetti.js/confetti.min.js"></script>
<script>
    confetti.start();
</script>
<div class="header  py-7 py-lg-8" style="background-color: #172b4d !important">
    <div class="container">
        <div class="header-body text-center mt-7 mb-7">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">{{ __('Welcome to ') . env('APP_NAME') }}</h1>
                </div>

            </div>

        </div>
        <div class="row container d-flex justify-content-center">
            <div class="template-demo mt-2">
                <h1 class="text-white text-center">{{ __('Download Now') }}</h1>
                <button class="btn btn-dark btn-icon-text">
                    <i class="fab fa-apple " style="font-size: 36px"></i>
                    <span class="d-inline-block text-left"> <small class="font-weight-light d-block">Available on
                            the</small> App Store </span>
                </button>
                <button class="btn btn-dark btn-icon-text">
                    <i class="fab fa-android  " style="font-size: 36px"></i>
                    <span class="d-inline-block text-left"> <small class="font-weight-light d-block">Get it on
                            the</small> Google
                        Play </span>
                </button>
            </div>
        </div>
        <div class="row mt-7 container d-flex justify-content-center">
            <div class="template-demo mt-2">
                <h1 class="text-white text-center">{{ __('View Glimpse ') }} <a href="">Here</a> </h1>
             <marquee>  <h3 class="text-red text-center">{{ __('You want your own ') }} <a href="" class="text-green">Buy Now</a> </h3> </marquee>
            </div>
        </div>
    </div>
    <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
            xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
    <div class="car-container">
        <div class="car-top1">
            <div class="window1"></div>
            <div class="window2"></div>
    
        </div>
        <div class="car-top2">
            <div class="door">
                <div class="door-knob"></div>
            </div>
        </div>
        <div class="car-bottom">
            <div class="wheel1-top"></div>
            <div class="wheel1">
                <div class="wheel-dot1"></div>
                <div class="wheel-dot2"></div>
                <div class="wheel-dot3"></div>
                <div class="wheel-dot4"></div>
    
            </div>
    
            <div class="wheel2-top"></div>
            <div class="wheel2">
                <div class="wheel-dot1"></div>
                <div class="wheel-dot2"></div>
                <div class="wheel-dot3"></div>
                <div class="wheel-dot4"></div>
            </div>
        </div>
    </div>
</div>

<div class="container mt--10 pb-5"></div>
<style>@keyframes driving {
0% {
left: -25%;
}

10% {
bottom: 0%;
}

20% {
transform: scale(0.5) rotateZ(-5deg);
bottom: 5%
}

25% {
transform: scale(0.5) rotateZ(0deg);
}

40% {
transform: scale(0.5) rotateZ(5deg);
}

50% {
transform: scale(0.5) rotateZ(0deg);
}

100% {
left: 110%;
bottom: 10%;
transform: scale(0.5) rotateZ(0deg);
}
}



@keyframes wheelsRotation {
100% {
transform: rotate(360deg);
}
}




/* CAR CONTAINER */

.car-container {
position: absolute;
bottom: -10%;
width: 430px;
height: 300px;
animation: driving 5s infinite linear;
transform: scale(0.5);
}

.car-container:after {
content: "";
width: 426px;
height: 1px;
margin-top: 88px;
display: block;
position: absolute;
left: -3%;
z-index: -1;
bottom: 0;
box-shadow: 2px -15px 25px 2px #000000;
}

/* WHEELS */

.wheel1,
.wheel2 {
width: 120px;
height: 120px;
background-color: grey;
border-radius: 50%;
border: 20px solid black;
position: absolute;
bottom: 0;
animation: wheelsRotation 1s infinite linear;
}

.wheel1 {
left: 5%;
}

.wheel1-top,
.wheel2-top {
bottom: 48px;
position: absolute;
width: 106px;
height: 80px;
border-radius: 50%;
z-index: 5;
box-shadow: 0px 13px 3px 0px rgba(240, 240, 240, 0.53);
transform: rotateX(180deg);
}

.wheel1-top {
left: 7%;
}

.wheel2-top {
right: 7%;
}

.wheel2 {
right: 5%;
}

.wheel-dot1,
.wheel-dot2 {
width: 10px;
height: 25px;
background-color: black;
position: absolute;
}

.wheel-dot3,
.wheel-dot4 {
width: 25px;
height: 10px;
background-color: black;
position: absolute;
}

.wheel-dot1 {
top: 10%;
left: 45%;
}

.wheel-dot2 {
bottom: 10%;
left: 45%;
}

.wheel-dot3 {
top: 45%;
right: 10%;
}

.wheel-dot4 {
top: 45%;
left: 10%;
}

.door {
width: 110px;
height: 100px;
border: 3px solid #B57A84;
position: absolute;
left: 36%;
top: 16px;
border-radius: 10% 40% 10% 10%;
}

.door-knob {
width: 30px;
height: 14px;
background-color: #E8E6E6;
border-radius: 30%;
position: absolute;
left: 20%;
top: 5%;
border: 1px solid lightcoral;
}

.car-top1 {
border-radius: 25% 40% 0 0;
background-color: #6A1621;
max-width: 100%;
width: 250px;
height: 130px;
position: absolute;
top: 0;
left: 4%;
}

.window1,
.window2 {
background-color: #E2F0F6;
border-radius: 5px;
position: absolute;
width: 40%;
height: 60%;
margin: 17px;
border: 9px solid #BF6D7B;
}

.window1 {
left: 0;
border-top-left-radius: 30%;
}

.window2 {
right: 0;
border-top-right-radius: 50%;
}

.car-top2 {
border-radius: 100px 200px 0 0;
background-color: #25659C;
border: 10px solid #72252F;
background-color: #9C2535;
max-width: 100%;
width: 430px;
height: 140px;
position: absolute;
bottom: 20%;
}











/*Headlights*/
.car-top1:after {
width: 13px;
height: 37px;
background-color: #BACCDA;
position: absolute;
bottom: -63px;
right: -168px;
z-index: 10;
content: " ";
border-radius: 10px;
border: 2px solid black;
border-left-style: none;
transform: rotate(-15deg);
}

.car-top2:after {
position: absolute;
bottom: 7px;
right: -340px;
content: " ";
width: 0;
height: 0;
border-top: 20px solid transparent;
border-bottom: 80px solid transparent;
border-right: 500px solid rgba(191, 188, 87, 0.7);
z-index: -1;
-webkit-mask-box-image: -webkit-linear-gradient(left, black, transparent);
-webkit-mask-box-image: -o-linear-gradient(left, black, transparent);
-webkit-mask-box-image: linear-gradient(to right, black, transparent);
transform: rotate(-9deg);
}</style>
@endsection
