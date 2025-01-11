document.addEventListener('DOMContentLoaded', () => {
    // Function to handle the Add to Wishlist button click
    document.querySelectorAll('.add-to-wishlist').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.productId;

            fetch('add-to-wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}`
            })
                .then(response => response.json())
                .then(data => {
                    // Show popup message
                    const popup = document.createElement('div');
                    popup.className = 'popup-message';
                    popup.textContent = data.message;

                    document.body.appendChild(popup);

                    setTimeout(() => {
                        popup.remove();
                    }, 3000);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});
