<style>
    * {
        margin: 0px;
        padding: 0px;
        box-sizing: border-box;
        scroll-behavior: smooth;
    }
    a {
        text-decoration: none;
    }

    ul {
        list-style: none;
    }

    :root {
        --main-color:#ffd6dc;
        --main-light:#fdf0f2;
        --main-dark:#f74b65;
        --product-bg-color:#f8f8f8;
    }

    /* Main */

    #main {
        min-height: 100vh;
        width: 100%;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    #main:after {
        content: '';
        position: absolute;
        right: 0px;
        top: 0px;
        width: 50%;
        background-color: var(--main-color);
        height: 100%;
        z-index: -1;
    }
    /* header */
    .header-top {
        max-width: 1200px;
        width: 90%;
        margin: auto;
        padding: 15px 0px;
        display: flex;
        align-items: center;
        justify-content: space-between; /* Default */
        position: relative;
    }
    header.header-fix {
        background-color: #ffffff;
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        z-index: 101;
        box-shadow: 2px 2px 30px rgba(0,0,0,0.05);
        animation: navanimation 0.6s;
    }
    header.header-fix .header-top {
        border-bottom: 1px solid #f7f7f7;
    }
    @keyframes navanimation {
        0% {
            top: -100%;
        }
        100% {
            top: 0%;
        }
    }

    .nav-location {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        left: 0; /* Vendoset në skajin e majtë */
    }
    .nav-location a{
        display: flex;
        justify-content: center;
        align-items: center;
        color: #000000;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .nav-location a svg {
        fill:var(--main-dark);
        margin-right: 5px;
    }
    .logo {
        max-width: 180px;
        max-height: 40px;
        display: flex;
        margin: 0 auto; /* Qendron logon */
    }
    .logo img {
        max-height: 40px;
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
    }
    .nav-btns {
        display: flex;
        justify-content: center;
        align-items: center;
        grid-gap: 25px;
        position: absolute;
        right: 0; /* Vendoset në skajin e djathtë */
    }
    .nav-btns a svg {
        fill: #3f3f3f;
        height: 18px;
        width: 20px;
    }
    .nav-cart {
        position: relative;
    }
    .nav-cart span {
        position: absolute;
        color: #ffffff;
        background-color: var(--main-dark);
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.6rem;
        font-weight: 600;
        right: -8px;
        top: -12px;
    }
    .navigation {
        display: flex;
        justify-content: center;
        align-items: center;
        max-width: 1200px;
        width: 90%;
        margin: auto;
        padding: 20px 0px;
        z-index: 101;
        position: relative;
    }
    .menu {
        display: flex;
        align-items: center;
    }
    .menu li a {
        margin: 0px 15px;
        color:#4d4d4d;
        letter-spacing: 0.5px;
        font-weight: 500;
        font-size: 0.8rem;
        transition: all ease 0.3s;
    }
    .menu li a:hover {
        color: #181818;
    }
    .menu li {
        position: relative;
    }
    .nav-label {
        padding: 2px 10px;
        background-color: var(--main-dark);
        color: #ffffff;
        font-weight: 500;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.6rem;
        text-transform: uppercase;
        position: absolute;
        right: -20px;
        top: -15px;
    }
    .nav-label::after {
        content: '';
        position: absolute;
        left: 10%;
        top: 100%;
        width: 0px;
        height: 0px;
        border-bottom: 3px solid transparent;
        border-right: 3px solid transparent;
        border-left: 3px solid transparent;
        border-top: 5px solid var(--main-dark);
    }
    /* main-content */
    .main-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        width: 90%;
        margin: auto;
        margin-bottom: 0px;
        padding-top: 20px;
    }
    .main-content-img {
        width: 100%;
        height: 75vh;
    }
    .main-content-img img {
        width: 100%;
        height: 100%;
        object-position: center;
        object-fit: contain;
    }
    .main-content-text {
        display: flex;
        flex-direction: column;
    }
    .main-content-text strong {
        color: var(--main-dark);
        text-transform: uppercase;
        letter-spacing: 10px;
        font-weight: 600;
    }
    .main-content-text h1 {
        font-size: 3rem;
        color: #181818;
        line-height: 3.7rem;
        font-weight: 600;
    }
    .main-content-text p {
        color: #5f5f5f;
        margin: 20px 0px;
        font-size: 0.9rem;
    }
    .main-content-text a {
        color: #ffffff;
        background-color: var(--main-dark);
        max-width: 150px;
        width:100%;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.9rem;
    }

    /* login */

    /* category */
    #category {
        max-width: 1200px;
        width: 90%;
        margin: 50px auto;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
        grid-gap: 50px;
        overflow-x: auto;
    }
    .category-box {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        padding-bottom: 25px;
    }
    .category-box:hover {
        opacity: 0.8;
    }

    .category-box-img {
        background-color: var(--main-light);
        border-radius: 50%;
        width: 150px;
        height: 150px;
        padding: 20px;
    }
    .category-box-img img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
    }
    .category-box strong {
        color: #1d1d1d;
        font-size: 0.9rem;
        margin-top: 10px;
        font-weight: 600;
        text-align: center;
    }
    /* Popular flowers */
    #popular {
        max-width: 1200px;
        width: 90%;
        margin: 50px auto;
    }
    #popular h2 {
        color: #1d1d1d;
        font-size: 1.6rem;
        font-weight: 600;
    }
    .popular-dress-container {
        display: grid;
        grid-template-columns: 1fr 300px;
        grid-gap: 50px;
        margin-top: 20px;
        align-items: flex-start;
    }
    .popular-product-container {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-gap: 40px;
    }
    .product-box{
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    .product-box-img {
        width: 100%;
        max-height: 400px;
        height: 100%;
        background-color: var(--product-bg-color);
        padding: 20px;
        border-radius: 5px;
    }
    .product-box-img img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
    }
    .product-box-img span {
        position: absolute;
        right: 5px;
        top: 5px;
        font-size: 0.8rem;
        color: #ffffff;
        background-color: var(--main-dark);
        font-size: 0.8rem;
        border-radius: 3px;
        letter-spacing: 0.2px;
        padding: 2px 10px;
    }
    .product-box-text{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .product-box-text .product-text-title {
        color: black;
        font-size: 1rem;
        font-weight: 600;
        margin-top: 10px;
    }
    .product-box-text span {
        color: var(--main-dark);
        font-size: 0.9rem;
        font-weight: 500;
        margin: 5px;
    }
    .product-box-text span del {
        color: #696969;
    }
    .product-box-text .product-cart-btn {
        border-top: 1px solid #e9e9e9;
        width: 100%;
        padding: 10px;
        color: #1d1d1d;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: all ease 0.3s;
    }
    .product-box-text .product-cart-btn svg {
        height: 16px;
        width: 20px;
        margin-right: 5px;
    }
    .product-box-text .product-cart-btn:hover {
        background-color: var(--main-dark);
        border-top: 1px solid transparent;
        color: #ffffff;
        fill: #ffffff;
    }
    .popular-banner {
        background-color: var(--main-light);
        width: 100%;
        min-height: 500px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        padding: 40px 30px;
        text-align: center;
    }
    .popular-banner-text {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .popular-banner-text h3{
        font-size: 1.3rem;
        color: #1d1d1d;
        font-weight: 500;
    }
    .popular-banner-text a {
        color: var(--main-dark);
        font-weight: 600;
        margin-top: 10px;
    }
    .popular-banner-img {
        width: 100%;
        height: 100%;
        margin-top: 30px;
    }
    .popular-banner-img img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* shopping banner */
    #shopping-banner {
        max-width: 1200px;
        width: 90%;
        margin: 50px auto;
        background-color: var(--main-light);
        padding: 30px;
        border-radius: 10px;
    }
    .shopping-banner-container{
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        max-width: 900px;
        margin: auto;
    }
    .shopping-banner-img {
        height: 300px;
        display: flex;
        justify-content: center;
    }
    .shopping-banner-img img {
        width: 100%;
        object-fit: contain;
        object-position: center;
    }
    .shopping-banner-text {
        display: flex;
        flex-direction: column;
        max-width: 400px;
    }
    .shopping-banner-text h3 {
        color: #181818;
        font-size: 1.8rem;
    }
    .shopping-banner-text strong {
        color:var(--main-dark);
        text-transform: uppercase;
        letter-spacing: 10px;
        font-weight: 500;
    }
    .shopping-banner-text p {
        color: #3f3f3f;
        margin: 10px 0px;
    }
    .shopping-banner-text a {
        color: #ffffff;
        background-color: var(--main-dark);
        max-width: 160px;
        width: 100%;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
        transition: all ease 0.3s;
    }
    .shopping-banner-text a {
        opacity: 0.8;
    }


    /* notification(contact)*/
    body.contact-notification-page {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: var(--main-light);
        color: var(--main-dark);
    }

    .contact-navbar {
        background-color: var(--main-dark);
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }

    .contact-navbar a {
        text-decoration: none;
        color: white;
        margin: 0 10px;
    }

    .contact-notification-box {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: var(--main-dark);
        color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        display: none;
        z-index: 1000;
    }

    .contact-notification-box p {
        margin: 0;
    }




    /* services */
    .services {
        display: flex;
        width: 90%;
        justify-content: center;
        align-items: center;
        margin: auto;
        flex-wrap: wrap;
        max-width: 1200px;
        margin-bottom: 20px;
    }
    .service-box {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border: 1px solid rgba(0,0,0,0.1);
        min-width: 250px;
        padding-bottom: 10px;
        margin: 5px;
        flex-grow: 0.7;
    }
    .service-box svg {
        fill: var(--main-dark);
        font-size: 2rem;
        margin: 15px;
    }
    .service-box span {
        color: #222222;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 1rem;
    }
    .service-box p {
        color: #878787;
        margin: 0px;
        font-size: 0.9rem;
    }
</style>

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
            <li><a href="homepage.php">Home</a></li>
            <li><a href="aboutus.php">About</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="cart.php">Order</a></li>
            <li><a href="#" id="contactBtn">Contact</a>
        </ul>
    </nav>
</header>
<!-- ======== contact notification ============= -->
<div class="contact-notification-box" id="notification">
    <h2>Contact Information</h2>
    <p><strong>Email:  </strong> noreply.bloomflowers@gmail.com </p>
    <p><strong>Phone:  </strong> +355 592 622 885 122</p>
    <p><strong>Business Hours: </strong> 24h/7 </p>
    <p><strong>Address:  </strong>Tirane, Albania; Teodor Keko Str</p>
</div>

<!-- ===========script=======================-->
<script src="homepage.js"></script>
<script src="timeout.js"></script>
