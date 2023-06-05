var swiper = new Swiper(".mySwiper4", {
    slidesPerView: 4,
    grid: {
        rows: 2,
    },
    spaceBetween: 10,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        // when window width is <= 640px
        1920: {
            slidesPerView: 2,
            grid: {
                rows: 1,
            }
        },
        640: {
            slidesPerView: 4,
            grid: {
                rows: 2,
            }
        }
    }
});
