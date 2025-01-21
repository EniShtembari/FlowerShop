<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!-- ======title====================== -->
    <title>HomePage</title>
    <!-- ======CSS====================== -->
    <link rel="stylesheet" href="homepage.css">
    <!-- ======fav-icon====================== -->
    <link rel="shortcun icon" href="images/onTop.png">
    <!-- ===========import-poppins-font===== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body class="contact-notification-page">
<!-- ======main================================= -->
<section id="main">
    <!-- ======header=========================== -->
    <header>
        <!--**header top**************-->
        <div class="header-top">

            <!--menu-icon**********-->
            <label for="menu-btn" class="menu-btn">
                <span class="nav-icon"></span>
            </label>
            <!--location-->
            <div class="nav-location">
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" height="1em"  width="1em" ><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
                    Tirane, Albania
                </a>
            </div>

            <!--logo-->
            <a href="#" class="logo">
                <img src="images/onTop.png" alt="logo">
            </a>

            <!--nav-btn-->
            <div class="nav-btns">
                <!--user-->
                <a href="myAccount.php" class="nav-user">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="1em"  width="1em" ><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>
                </a>
                <!--cart-->
                <a href="cart.php" class="nav-cart">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" height="1em"  width="1em"><path d="M423.3 440.7c0 25.3-20.3 45.6-45.6 45.6s-45.8-20.3-45.8-45.6 20.6-45.8 45.8-45.8c25.4 0 45.6 20.5 45.6 45.8zm-253.9-45.8c-25.3 0-45.6 20.6-45.6 45.8s20.3 45.6 45.6 45.6 45.8-20.3 45.8-45.6-20.5-45.8-45.8-45.8zm291.7-270C158.9 124.9 81.9 112.1 0 25.7c34.4 51.7 53.3 148.9 373.1 144.2 333.3-5 130 86.1 70.8 188.9 186.7-166.7 319.4-233.9 17.2-233.9z"/></svg>
                    <span>0</span>
                </a>
                <!--log out-->
                <a href="logout.php" class="nav-search">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="1em"  width="1em"><path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg>
                </a>
            </div>
        </div>

        <!--navigation-->
        <nav class="navigation">
            <!--menu-->
            <ul class="menu">
                <li><a href="#">Home</a></li>
                <li><a href="aboutus.php">About</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li>
                    <a href="#">Popular</a>
                </li>
                <li><a href="#">Order</a></li>
                <li><a href="#" id="contactBtn">Contact</a>
            </ul>
        </nav>

    </header>

    <!-- ======content=========================== -->
    <div class="main-content">
        <!--text-->
        <div class="main-content-text">
            <strong>About us</strong>
            <h1>Welcome<br>to our shop</h1>
            <p><b>"At Bloom Flowers 🌸 , every petal tells a story <br> of love,
                    beauty, and connection. Discover our <br>passion for crafting stunning floral arrangements that bring joy to every occasion." </b> </p>
            <a href="aboutus.php">LEARN MORE</a>
        </div>
        <!--img-->
        <div class="main-content-img">
            <img src="images/model.png" alt="model">
        </div>
    </div>
</section>


<!-- ======== contact notification ============= -->
<div class="contact-notification-box" id="notification">
    <h2>Contact Information</h2>
    <p><strong>Email:  </strong> noreply.bloomflowers@gmail.com </p>
    <p><strong>Phone:  </strong> +355 592 622 885 122</p>
    <p><strong>Business Hours: </strong> 24h/7 </p>
    <p><strong>Address:  </strong>Tirane, Albania; Teodor Keko Str</p>
</div>

<!-- =================Category================== -->
<section id="category">
    <!--box1-->
    <a href="#" class="category-box">
        <!--img-->
        <div class="category-box-img">
            <img src="images/c1.png" alt="Annual Flower">
        </div>
        <!--text-->
        <strong>Annual Flower</strong>
    </a>
    <!--box2-->
    <a href="#" class="category-box">
        <!--img-->
        <div class="category-box-img">
            <img src="images/c2.png" alt="Perennial Flower">
        </div>
        <!--text-->
        <strong>Perennial Flower</strong>
    </a>
    <!--box3-->
    <a href="#" class="category-box">
        <!--img-->
        <div class="category-box-img">
            <img src="images/c3.png" alt="Biennial Flower">
        </div>
        <!--text-->
        <strong>Biennial Flower</strong>
    </a>
    <!--box4-->
    <a href="#" class="category-box">
        <!--img-->
        <div class="category-box-img">
            <img src="images/c4.png" alt="Rose Flower">
        </div>
        <!--text-->
        <strong>Rose Flower</strong>
    </a>
    <!--box5-->
    <a href="#" class="category-box">
        <!--img-->
        <div class="category-box-img">
            <img src="images/c5.png" alt="SunFlower">
        </div>
        <!--text-->
        <strong>SunFlower</strong>
    </a>
    <!--box6-->
    <a href="#" class="category-box">
        <!--img-->
        <div class="category-box-img">
            <img src="images/c6.png" alt="Hydrangea">
        </div>
        <!--text-->
        <strong>Hydrangea</strong>
    </a>


</section>

<!-- =================Popular================== -->
<section id="popular">
    <!--heading-->
    <h2>Popular Flowers</h2>
    <!--container -->
    <div class="popular-dress-container">
        <!--product-container-->
        <div class="popular-product-container">

            <!--box1-->
            <div class="product-box">
                <!--img-->
                <a href="#" class="product-box-img">
                    <img src="images/p1.png" alt="product">
                </a>
                <!--text-->
                <div class="product-box-text">
                    <a href="" class="product-text-title">Flower Pot</a>
                    <span>20$ <del>40$</del></span>
                    <a href="#" class="product-cart-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="1em"  width="1em">
                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
                        </svg>
                        1
                    </a>
                </div>
            </div>

            <!--box2-->
            <div class="product-box">
                <!--img-->
                <a href="#" class="product-box-img">
                    <img src="images/p2.png" alt="product">
                </a>
                <!--text-->
                <div class="product-box-text">
                    <a href="" class="product-text-title">Flower Pot</a>
                    <span>20$ <del>40$</del></span>
                    <a href="#" class="product-cart-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="1em"  width="1em">
                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
                        </svg>
                        2
                    </a>
                </div>
            </div>

            <!--box3-->
            <div class="product-box">
                <!--img-->
                <a href="#" class="product-box-img">
                    <img src="images/p3.png" alt="product">
                </a>
                <!--text-->
                <div class="product-box-text">
                    <a href="" class="product-text-title">Flower Pot</a>
                    <span>20$ <del>40$</del></span>
                    <a href="#" class="product-cart-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="1em"  width="1em">
                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
                        </svg>
                        3
                    </a>
                </div>
            </div>

            <!--box4-->
            <div class="product-box">
                <!--img-->
                <a href="#" class="product-box-img">
                    <img src="images/p4.png" alt="product">
                </a>
                <!--text-->
                <div class="product-box-text">
                    <a href="" class="product-text-title">Flower Pot</a>
                    <span>20$ <del>40$</del></span>
                    <a href="#" class="product-cart-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="1em"  width="1em">
                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
                        </svg>
                        4
                    </a>
                </div>
            </div>

            <!--box5-->
            <div class="product-box">
                <!--img-->
                <a href="#" class="product-box-img">
                    <img src="images/p5.png" alt="product">
                </a>
                <!--text-->
                <div class="product-box-text">
                    <a href="" class="product-text-title">Flower Pot</a>
                    <span>20$ <del>40$</del></span>
                    <a href="#" class="product-cart-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="1em"  width="1em">
                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
                        </svg>
                        5
                    </a>
                </div>
            </div>

            <!--box6-->
            <div class="product-box">
                <!--img-->
                <a href="#" class="product-box-img">
                    <img src="images/p6.png" alt="product">
                </a>
                <!--text-->
                <div class="product-box-text">
                    <a href="" class="product-text-title">Flower Pot</a>
                    <span>20$ <del>40$</del></span>
                    <a href="#" class="product-cart-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="1em"  width="1em">
                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
                        </svg>
                        6
                    </a>
                </div>
            </div>

        </div>
        <!--banner-->
        <div class="popular-banner">
            <!--text-->
            <div class="popular-banner-text">
                <h3>Summer Flower Collection</h3>
                <a href="#">Shop Now</a>
            </div>
            <!--img-->
            <div class="popular-banner-img">
                <img src="images/banner.webp" alt="Banner">
            </div>

        </div>

    </div>
</section>



<!-- ===========shopping-banner=======================-->
<section id="shopping-banner">
    <div class="shopping-banner-container">
        <!--text-->
        <div class="shopping-banner-text">
            <strong>Bloom 🌸</strong>
            <h3>Find Your Perfect Bloom</h3>
            <p>"Explore our handpicked collection of stunning floral arrangements and gifts for every occasion. Let Petal Paradise bring beauty to your doorstep with just a click!"</p>
            <a href="shop.php">Shop Now</a>
        </div>
        <!-- img-->
        <div class="shopping-banner-img">
            <img src="images/shoes-bag.png" alt="banner">
        </div>
    </div>
</section>

<!-- ===========services======================-->
<section class="services">
    <!--service-box-->
    <div class="service-box">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"  height="1em"  width="1em"><path d="M112 0C85.5 0 64 21.5 64 48V96H16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 272c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 48c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 240c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 208c8.8 0 16 7.2 16 16s-7.2 16-16 16H64V416c0 53 43 96 96 96s96-43 96-96H384c0 53 43 96 96 96s96-43 96-96h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V288 256 237.3c0-17-6.7-33.3-18.7-45.3L512 114.7c-12-12-28.3-18.7-45.3-18.7H416V48c0-26.5-21.5-48-48-48H112zM544 237.3V256H416V160h50.7L544 237.3zM160 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96zm272 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0z"/></svg>
        <span>Free Shipping</span>

        @@ -314,69 +356,68 @@
        <!-- ===========footer======================-->
        <footer>
            <div class="footer-container">
                <!-- company-box-->
                <div class="footer-company-box">
                    <!--logo-->
                    <a href="" class="footer-logo">
                        <img src="images/onTop.png" alt="logo">
                    </a>
                    <!--details-->
                    <p>Feel free to reach out to us for any inquiries, custom orders, or to brighten someone's day with a beautiful bouquet!</p>
                    <!--social-->
                    <div class="footer-social">
                        <!--facebook-->
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"  width="1em"  viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg>
                        </a>
                        <!--insta-->
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="1em"  width="1em"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                        </a>
                        <!--twitter-->
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
                        </a>
                        <!--youtube-->
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" height="1em"  width="1em" ><path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg>
                        </a>
                    </div>
                </div>
                <!-- ===========link======================-->
                <div class="footer-link-box">
                    <strong>Main Link's</strong>
                    <ul>
                        <li><a href="homepage.php">Home</a></li>
                        <li><a href="aboutus.php">About</a></li>
                        <li><a href="shop.php">Shop</a></li>
                        <li><a href="#">Popular</a></li>
                        <li><a href="cart.php">Order</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>

                <!-- ===========link======================-->

                <!-- ===========subscribe======================-->
                <!--  <div class="footer subscribe">
                      <strong>Subscribe Now</strong>
                      <p> Stay updated on our latest floral creations</p>
                      <div class="subscribe-box">
                          <input type="email" placeholder="Example@gmail.com" name="subscribe" required/>
                          <button>Subscribe</button>
                      </div>
               </div>&#45;&#45;-->
            </div>
            <!-- ===========bottom======================-->
            <div class="footer-bottom">
                <span>Made From Web Dev. Group</span>
                <span>&copy; Copyright 2025 - Web Development</span>
            </div>
        </footer>


        <!-- ===========script=======================-->
        <script src="homepage.js"></script>

</body>
</html>