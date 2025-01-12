function openModal(id, name, image, discount, currentPrice, originalPrice) {
    document.getElementById('edit-productID').value = id;
    document.getElementById('edit-productName').value = name;
    document.getElementById('edit-imageURL').value = image;
    document.getElementById('edit-discountPercentage').value = discount;
    document.getElementById('edit-currentPrice').value = currentPrice;
    document.getElementById('edit-originalPrice').value = originalPrice;

    document.getElementById('edit-modal').classList.add('active');
    document.getElementById('modal-overlay').classList.add('active');
}

// Close modal when clicking outside
document.getElementById('modal-overlay').addEventListener('click', () => {
    document.getElementById('edit-modal').classList.remove('active');
    document.getElementById('modal-overlay').classList.remove('active');
});