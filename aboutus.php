
<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flower Shop</title>
  <link rel="stylesheet" href="aboutus.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" >
</head>
<body>

<!--ABOUT-SECTION-->
<section class="about" id="about">
    <h1 class="heading" > <span> ABOUT US</span> </h1>
    <div class="row">
        <div class="photo-cont">
            <img src="composition/florist.jpg" alt="Flowers">
            <h3>Best Flower Sellers</h3>
        </div>
        <div class="content">
            <h3>Why Choose Us?</h3>
           <p>Choosing the right flower shop can make all the difference when it comes to creating memorable moments, and FLOWER stands out for all the right reasons. With a reputation for exceptional quality and artistry, we pride ourselves on offering fresh, hand-selected blooms that are arranged with care and creativity. Whether you're looking for a stunning bouquet to celebrate a special occasion, a thoughtful arrangement to express your feelings, or elegant floral designs for an event, we go above and beyond to bring your vision to life. Our commitment to personalized service ensures every order reflects your unique style and sentiment. At Bloom Flowers, we believe flowers are more than gifts—they’re experiences of beauty and emotion, and we’re dedicated to making every delivery truly unforgettable.</p>
            <a href="#" class="btn" id="learn-more">Learn More</a>
        </div>
    </div>
</section>

<!--  Information Window -->
<div class="info-window" id="info-window">
    <div class="info-content">
        <span class="close-window" id="close-window">&times;</span>
        <h2>More About Us</h2>
        <p>We pride ourselves on offering fresh, hand-selected blooms and creating beautiful, thoughtful floral arrangements for every occasion.</p>
   <p> Founded in 1995, we have been a trusted provider of high-quality flowers for over two decades. We started as a small family business, but our passion for floral design and commitment to quality has helped us grow into one of the leading flower shops in the region.</p>
    </div>
</div>

<!--ICON SECTION -->
<section class="icon-container">
    <div class="icons">
        <img src="composition/delivery-man.png" alt="delivery man">
        <div class="info">
            <h3>Free Delivery</h3>
            <span>on all orders</span>
        </div>
    </div>

    <div class="icons">
        <img src="composition/money-bag.png" alt="money">
        <div class="info">
            <h3>10 days return</h3>
            <span>moneyback guarantee</span>
        </div>
    </div>

    <div class="icons">
        <img src="composition/offer.png" alt="offer">
        <div class="info">
            <h3>Offer & Gifts</h3>
            <span>on all orders</span>
        </div>
    </div>

    <div class="icons">
        <img src="composition/payment-method.png" alt="payment">
        <div class="info">
            <h3>Secure Payments</h3>
            <span>Protected by PayPal</span>
        </div>
    </div>
</section>

<!--PRODUCT SECTION-->
<section class="product" id="product">
    <h1 class="heading latest"> <span>Latest Products</span> </h1>
    <div class="box-container">
        <!--prd1-->
        <div class="box">
            <span class="discount"> -10% </span>
            <div class="image">
                <img src="composition/eee4c8399b08391f5beeb9b50b8b327a.jpg" alt="flower">

            </div>
            <div class="content">
                <h3>Flower Pot</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>


        <!--prd2-->
        <div class="box">
            <span class="discount"> -15% </span>
            <div class="image">
                <img src="composition/2e3bdd6d45427a7cde0df12d13cb8b01.jpg" alt="flower">
            </div>
            <div class="content">
                <h3>Flower Pot</h3>
                <div class="price">$18.99 <span>$20.99</span></div>
            </div>
        </div>

        <!--prd3-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/ca3e5ae2450f0bc3ecb9bc209c8d87b6.jpg" alt="flower">
            </div>
            <div class="content">
                <h3>Flower Pot</h3>
                <div class="price">$15.99 <span>$25.99</span></div>
            </div>
        </div>

        <!--prd4-->
        <div class="box">
            <span class="discount"> -25% </span>
            <div class="image">
                <img src="composition/c65826240e6dc5242eca1926cee31f69.jpg" alt="flower">
            </div>
            <div class="content">
                <h3>Flower Pot</h3>
                <div class="price">$27.95 <span>$30</span></div>
            </div>
        </div>
    </div>
</section>

<!-- OUR PROCESS SECTION -->
<section class="our-process" id="our-process">
    <h1 class="heading"> <span>Our Process</span> </h1>
    <div class="process-timeline">
        <div class="process-step fade-in">
            <div class="circle-image">
                <img src="images/handpicking.jpg" alt="Fresh Flowers">
            </div>
            <h3>Step 1: Handpicked Fresh Blooms</h3>
            <p>We source the freshest flowers directly from trusted growers to ensure top quality and vibrant arrangements.</p>
        </div>
        <div class="process-step fade-in">
            <div class="circle-image">
                <img src="images/creative.jpg" alt="Creative Design">
            </div>
            <h3>Step 2: Creative Design</h3>
            <p>Our skilled florists meticulously craft every bouquet and arrangement with a blend of creativity and precision.</p>
        </div>
        <div class="process-step fade-in">
            <div class="circle-image">
                <img src="images/delivery.jpg" alt="Delivery">
            </div>
            <h3>Step 3: Timely Delivery</h3>
            <p>We ensure your flowers arrive fresh and on time, making your special moments even more memorable.</p>
        </div>
    </div>
</section>




<script src="about.js"></script>
<script src="timeout.js"></script>
<?php
include 'footer.php';
?>
</body>
</html>