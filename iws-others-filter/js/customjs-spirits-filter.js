// var swiper = new Swiper(".mySwiper1", {
//     slidesPerView: 4,
//     grid: {
//         rows: 4,
//     },
//     spaceBetween: 10,
//     navigation: {
//         nextEl: ".swiper-button-next",
//         prevEl: ".swiper-button-prev",
//     },
// });
const filterButtons = document.querySelectorAll('.filter');
const listItems = document.querySelectorAll('.image-list li');

filterButtons.forEach(button => {
    button.addEventListener('click', updateFilter);
});

function updateFilter() {
    const selectedGroup = this.getAttribute('data-group');

    listItems.forEach(item => {
        const itemGroup = item.classList[0];
        if (selectedGroup === 'all' || itemGroup === selectedGroup) {
            item.classList.remove('hide');
        } else {
            item.classList.add('hide');
        }
    });

    filterButtons.forEach(button => {
        if (button.getAttribute('data-group') === selectedGroup) {
            button.classList.add('active');
        } else {
            button.classList.remove('active');
        }
    });

    const visibleItems = document.querySelectorAll('.image-list li:not(.hide)');
    if (visibleItems.length > 0) {
        document.querySelector('.image-list').style.display = 'flex';
    } else {
        document.querySelector('.image-list').style.display = 'none';
    }
}