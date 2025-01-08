<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="myAccount.css">
</head>
<body>
<div class="header">
    <div class="logo">MyPlatform</div>
    <nav>
        <a href="#">Send a Parcel</a>
        <a href="#">Track My Parcel</a>
        <a href="aboutus.html">About Us</a>
        <a href="#">Help</a>
        <a href="#">Contact Us</a>
    </nav>
    <div class="account-actions">
        <a href="#">My Account</a>
        <a href="#">Log Out</a>
    </div>
</div>
<main>
    <h1>My Account</h1>
    <div class="account-options">
        <div class="card">
            <img src="/icons/4357459.png" alt="Orders">
            <p>My Orders</p>
        </div>
        <div class="card">
            <img src="/icons/placeholder.png" alt="Address">
            <p>Address Book</p>
        </div>
        <div class="card" onclick="location.href='profileSettings.html';" style="cursor: pointer;">
            <img src="/icons/setting.png" alt="Settings">
            <p>Profile Settings</p>
        </div>
        <div class="card">
            <img src="/icons/faq.png" alt="FAQ">
            <p>Help and FAQ</p>
        </div>
    </div>
    <h2>Latest Parcel</h2>
    <div class="latest-parcel">
        <div class="parcel-item">
            <p><strong>Order Date:</strong> 10/08/2018</p>
            <p><strong>Order ID:</strong> P2P12093218</p>
            <p><strong>From:</strong> UK Mainland</p>
            <p><strong>To:</strong> Spain</p>
            <p><strong>Status:</strong> In Transit - <a href="#">Track</a></p>
        </div>
        <div class="parcel-item">
            <p><strong>Order Date:</strong> 10/08/2018</p>
            <p><strong>Order ID:</strong> P2P12093218</p>
            <p><strong>From:</strong> UK Mainland</p>
            <p><strong>To:</strong> Spain</p>
            <p><strong>Collecting Date:</strong> Tue, 16 Jul, 12:30 pm - 5:30 pm</p>
            <p><strong>Status:</strong> Waiting to Pickup</p>
        </div>
    </div>
</main>
</body>
</html>
