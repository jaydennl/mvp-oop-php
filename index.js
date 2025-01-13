function scrollCarousel(id, direction) {
    const carousel = document.getElementById(id);
    const itemWidth = carousel.querySelector('.item').clientWidth + 22; // Item width + gap
    carousel.scrollBy({ left: direction * itemWidth, behavior: 'smooth' });

    // Reveal hidden items when scrolling right
    if (direction === 1) {
        const hiddenItems = carousel.querySelectorAll('.item.hidden');
        hiddenItems.forEach(item => {
            item.classList.remove('hidden');
        });
    }
}