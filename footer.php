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

    /* footer */
    footer {
        width: 100%;
    }
    .footer-container {
        max-width: 1200px;
        width: 90%;
        margin: 0px auto;
        padding: 50px 0px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .footer-company-box, .footer-subscribe {
        max-width: 330px;
    }
    .footer-company-box .footer-logo {
        max-width: 150px;
        height: 45px;
        display: flex;
    }
    .footer-company-box .footer-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        max-height: 45px;
    }
    .footer-company-box p, .footer-subscribe p {
        color: #585858;
        margin: 5px 0px;
    }
    .footer-social {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }
    .footer-social a {
        margin-top: 10px;
        margin-right: 10px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #e9e9e9;
        fill: #333333;
        font-size: 0.9rem;
    }
    .footer-social a:hover {
        fill: #ffffff;
        background-color: var(--main-dark);
        border: 1px solid transparent;
    }
    .footer-link-box {
        display: flex;
        flex-direction: column;
    }
    .footer-link-box strong, .footer-subscribe strong {
        color: #3b3b3b;
        font-size: 1.2rem;
        font-weight: 600;
    }
    .footer-link-box ul {
        margin-top: 5px;
    }
    .footer-link-box ul li a {
        color: #585858;
        margin-bottom: 4px;
        display: flex;
        transition: all ease 0.3s;
    }
    .footer-link-box ul li a:hover {
        color: var(--main-dark);
    }
    .subscribe-box {
        width: 100% ;
        border: 1px solid #dadada;
        display: flex;
        justify-content: center;
        height: 100%;
        margin-top: 10px;
    }
    .service-box input {
        width: 100%;
        border: none;
        outline: none;
        background-color: transparent;
        padding: 0px 15px;
    }
    .subscribe-box button{
        border: none;
        outline: none;
        cursor: pointer;
        background-color: var(--main-dark);
        color: #ffffff;
        text-transform: uppercase;
        font-weight: 500;
        height: 40px;
        padding: 0px 20px;
    }
    .footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #e9e9e9;
        padding: 20px 0px;
        width: 90%;
        max-width: 1200px;
        flex-wrap: wrap;
        margin: auto;
        grid-gap: 10px;
    }
    .footer-bottom span {
        color: #252525;
        font-size: 0.9rem;
    }
</style>

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
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Shop</a></li>
                <li><a href="#">Popular</a></li>
                <li><a href="#">Order</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>

    </div>
    <!-- ===========bottom======================-->
    <div class="footer-bottom">
        <span>Made From Web Dev. Group</span>
        <span>&copy; Copyright 2025 - Web Development</span>
    </div>
</footer>