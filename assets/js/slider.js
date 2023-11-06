
function waitForEle(selector) {
  return new Promise(resolve => {
      if (document.querySelector(selector)) {
          return resolve(document.querySelector(selector));
      }

      const observer = new MutationObserver(mutations => {
          if (document.querySelector(selector)) {
              observer.disconnect();
              resolve(document.querySelector(selector));
          }
      });

      observer.observe(document, {
          childList: true,
          subtree: true
      });
  });
}

waitForEle('.akzent-swiper').then((ele) => {
  const swiper = new Swiper('.akzent-swiper', {
    speed: 1000,
    loop: true,
    autoHeight: true,
    slidesPerView: 1,
    spaceBetween: 320,
    centeredSlides: false,
    grabCursor: false,
    effect: 'coverflow',
    coverflowEffect: {
      rotate: 60,
      slideShadows: false,
    },

    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  });
})
