function openModal(id, name, image, discount, currentPrice, originalPrice) {
    const productIDField = document.getElementById('edit-productID');
    if (productIDField) {
        productIDField.value = id;
        document.getElementById('edit-productName').value = name;
        document.getElementById('edit-imageURL').value = image;
        document.getElementById('edit-discountPercentage').value = discount;
        document.getElementById('edit-currentPrice').value = currentPrice;
        document.getElementById('edit-originalPrice').value = originalPrice;

        document.getElementById('edit-modal').classList.add('active');
        document.getElementById('modal-overlay').classList.add('active');
    } else {
        console.error('Modal fields are missing in the DOM.');
    }
}