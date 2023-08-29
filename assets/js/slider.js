const swiper = new Swiper('.swiper', {
  autoHeight: true,
  slidesPerView: 1,
  spaceBetween: 30,

  centeredSlides: true,
  grabCursor: true,

  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },

  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  scrollbar: {
    el: '.swiper-scrollbar',
  },
});
