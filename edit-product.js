function openModal(id, name, image, discount, currentPrice, originalPrice) {
    document.getElementById('edit-productID').value = id;
    document.getElementById('edit-productName').value = name;
    document.getElementById('edit-imageURL').value = image;
    document.getElementById('edit-discountPercentage').value = discount;
    document.getElementById('edit-currentPrice').value = currentPrice;
    document.getElementById('edit-originalPrice').value = originalPrice;

    document.getElementById('edit-modal').classList.add('active');
}

// Close modal when clicking outside
window.addEventListener('click', (event) => {
    const modal = document.getElementById('edit-modal');
    if (event.target === modal) {
        modal.classList.remove('active');
    }
});