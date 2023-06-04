var swiper = new Swiper(".mySwiper4", {
    slidesPerView: 4,
    grid: {
        rows: 4,
    },
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        // when window width is <= 640px
        1920: {
            slidesPerView: 4,
            grid: {
                rows: 2,
            }
        },
        // 640: {
        //     slidesPerView: 2,
        //     grid: {
        //         rows: 1,
        //     }
        // },
        // 800: {
        //     slidesPerView: 2,
        //     grid: {
        //         rows: 1,
        //     }
        // }
    }
});
