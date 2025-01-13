function scrollCarousel(id, direction) {
    const container = document.getElementById(id);
    const scrollAmount = 160; // Adjust scroll amount (width of each item + gap)

    container.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
}
