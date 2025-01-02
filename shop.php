<?php
$conn=mysqli_connect("localhost","root","","flowershop");
$sql="SELECT * from products";
$result=mysqli_query($conn,$sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
  <link rel="stylesheet" href="shop.css">
    <link href="https://fonts.googleapis.com/css2?family=Diphylleia&display=swap" rel="stylesheet">
</head>
<body>

<!--page1-->
<div class="shop">
    <div class="content">
        <h1>Our Shop</h1>
    </div>
</div>


<!--product section-->
<section class="product" id="product">

    <div class="box-container">

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Dynamically generate product boxes
                echo '
                <div class="box">
                    <span class="discount">-' . htmlspecialchars($row["discount"]) . '%</span>
                    <div class="image">
                        <img src="' . htmlspecialchars($row["image_url"]) . '" alt="' . htmlspecialchars($row["name"]) . '">
                        <div class="icons">
                            <a href="#" class="likes">❤️</a>
                            <a href="#" class="cart-btn">Add to cart</a>
                            <a href="#" class="shares">🔗</a>
                        </div>
                    </div>
                    <div class="content">
                        <h3>' . htmlspecialchars($row["name"]) . '</h3>
                        <div class="price">$' . htmlspecialchars($row["price"]) . ' <span>$' . htmlspecialchars($row["original_price"]) . '</span></div>
                    </div>
                </div>';
            }
        } else {
            echo '<p>No products available.</p>';
        }
        ?>
        <!--prd1-->
        <div class="box">
            <span class="discount"> -10% </span>
            <div class="image">
                <img src="composition/eee4c8399b08391f5beeb9b50b8b327a.jpg" alt="flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Bouqet of flowers</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>


        <!--prd2-->
        <div class="box">
            <span class="discount"> -15% </span>
            <div class="image">
                <img src="composition/2e3bdd6d45427a7cde0df12d13cb8b01.jpg" alt="flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Bouqet of flowers</h3>
                <div class="price">$18.99 <span>$20.99</span></div>
            </div>
        </div>

        <!--prd3-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/ca3e5ae2450f0bc3ecb9bc209c8d87b6.jpg" alt="flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Bouqet of flowers</h3>
                <div class="price">$15.99 <span>$25.99</span></div>
            </div>
        </div>

        <!--prd4-->
        <div class="box">
            <span class="discount"> -25% </span>
            <div class="image">
                <img src="composition/c65826240e6dc5242eca1926cee31f69.jpg" alt="flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Bouqet of flowers</h3>
                <div class="price">$27.95 <span>$30</span></div>
            </div>
        </div>

        <!--prd5-->
        <div class="box">
            <span class="discount"> -30% </span>
            <div class="image">
                <img src="composition/373fba33143141636e7c3ddf525cd3a2.jpg" alt="flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Bouqet of flowers</h3>
                <div class="price">$24.99 <span>$30.99</span></div>
            </div>
        </div>


        <!--prd6-->
        <div class="box">
            <span class="discount"> -15% </span>
            <div class="image">
                <img src="composition/399e4b293fc85ed541cfb715019777d6.jpg" alt="flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Bouqet of flowers</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>


        <!--prd7-->
        <div class="box">
            <span class="discount"> -10% </span>
            <div class="image">
                <img src="composition/pinktulips.jpg" alt="flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Bouqet of flowers</h3>
                <div class="price">$17.99 <span>$19.99</span></div>
            </div>
        </div>

        <!--prd8-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/redroses.jpg" alt="flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Bouqet of flowers</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

        <!--prd9-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/c54d4d1652fb46bd80cd2566c3432cb3.jpg" alt="wedding-flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Wedding Flower</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

        <!--prd9-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/whitewedding.jpg" alt="wedding-flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Wedding Flower</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

        <!--prd10-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/wedd.jpg" alt="wedding-flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Wedding Flower</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

        <!--prd11-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/wedding.jpg" alt="wedding-flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Wedding Flower</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>


        <!--prd12-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/outsidedecor.jpg" alt="outside-flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Outside Decor</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

        <!--prd13-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/57fed4f78056f52128a3ca48f073a5c7.jpg" alt="outside-flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Outside Decor</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

        <!--prd14-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/ice%20flower.jpg" alt="outside-flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Outside Decor</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

        <!--prd15-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/pinkoutside.jpg" alt="outside-flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Outside Decor</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

        <!--prd16-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/green1.jpg" alt="plants">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Green Plants</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

        <!--prd16-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/green7.png" alt="green">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Green Plants</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

        <!--prd17-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/green3.png" alt="green">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Green Plants</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

        <!--prd18-->
        <div class="box">
            <span class="discount"> -20% </span>
            <div class="image">
                <img src="composition/green5.png" alt="outside-flower">
                <div class="icons">
                    <a href="#" class="likes">❤️</a>
                    <a href="#" class="cart-btn">Add to cart</a>
                    <a href="#" class="shares">🔗</a>
                </div>
            </div>
            <div class="content">
                <h3>Green Plants</h3>
                <div class="price">$15.99 <span>$18.99</span></div>
            </div>
        </div>

    </div>


    <!--next button-->
    <div class="pagination-container">
        <div class="pagination">
            <a href="shop.html" class="page active">1</a>
            <a href="shop1.html" class="page">2</a>
            <a href="shop1.html" class="page">next</a>
        </div>
    </div>





</section>
</body>
</html>

