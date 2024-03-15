"use strict";
document.addEventListener("DOMContentLoaded", function () {
  /**
  * Slide Up
  */
  const slideUp = (target, duration = 500) => {
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + "ms";
    target.style.boxSizing = "border-box";
    target.style.height = target.offsetHeight + "px";
    target.offsetHeight;
    target.style.overflow = "hidden";
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    window.setTimeout(() => {
      target.style.display = "none";
      target.style.removeProperty("height");
      target.style.removeProperty("padding-top");
      target.style.removeProperty("padding-bottom");
      target.style.removeProperty("margin-top");
      target.style.removeProperty("margin-bottom");
      target.style.removeProperty("overflow");
      target.style.removeProperty("transition-duration");
      target.style.removeProperty("transition-property");
    }, duration);
  }
  /**
  * Slide Down
  */
  const slideDown = (target, duration = 500) => {
    target.style.removeProperty("display");
    let display = window.getComputedStyle(target).display;

    if (display === "none") display = "block";

    target.style.display = display;
    let height = target.offsetHeight;
    target.style.overflow = "hidden";
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    target.offsetHeight;
    target.style.boxSizing = "border-box";
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + "ms";
    target.style.height = height + "px";
    target.style.removeProperty("padding-top");
    target.style.removeProperty("padding-bottom");
    target.style.removeProperty("margin-top");
    target.style.removeProperty("margin-bottom");
    window.setTimeout(() => {
      target.style.removeProperty("height");
      target.style.removeProperty("overflow");
      target.style.removeProperty("transition-duration");
      target.style.removeProperty("transition-property");
    }, duration);
  }
  /**
   * Slide Toggle
   */
  const slideToggle = (target, duration = 500) => {
    if (
      target.attributes.style === undefined ||
      target.style.display === "none"
    ) {
      return slideDown(target, duration);
    } else {
      return slideUp(target, duration);
    }
  }
  /**
  * Primary Menu
  */
  const body = document.querySelector("body");
  const mdScreen = "(max-width: 991px)";
  const mdScreenSize = window.matchMedia(mdScreen);
  const menuHasSub = document.querySelectorAll(".has-sub");

  const mdScreenSizeActive = (screen) => {
    if (screen.matches) {
      // Menu Toggle
      const menuToggleHandler =
        document.querySelectorAll(".menu-toggle");
      if (menuToggleHandler) {
        menuToggleHandler.forEach((e) => {
          e.addEventListener("click", (el) => {
            el.stopPropagation();
            document.body.classList.toggle("menu-open");
          });
        });
      }
      // Menu Toggle End

      // if menu has sub
      menuHasSub.forEach((e) => {
        e.addEventListener("click", (el) => {
          el.preventDefault();
          el.stopPropagation();
          el.target.classList.toggle("active");
          const menuSub = e.nextElementSibling;
          slideToggle(menuSub, 500);
        });
      });
      // if menu has sub end

      // Close submenu on click outside
      document.addEventListener("click", () => {
        if (document.body.classList.contains("menu-open")) {
          document.body.classList.remove("menu-open");
        }
      });
      // Close submenu on click outside end

      // Menu Nav Stop Propagation
      const primaryNavContains = document.querySelectorAll(
        ".primary-nav__contains"
      );
      if (primaryNavContains.length) {
        primaryNavContains.forEach((e) => {
          e.addEventListener("click", (el) => {
            el.stopPropagation();
          });
        });
      }
      // Menu Nav Stop Propagation end
    } else {
      menuHasSub.forEach((e) => {
        e.addEventListener("click", (el) => {
          el.preventDefault();
        });
      });
    }
  };
  mdScreenSize.addEventListener("change", (e) => {
    if (e.matches) {
      window.location.reload();
      mdScreenSizeActive(e);
    } else {
      mdScreenSize.removeEventListener("change", (e) => {
        mdScreenSizeActive(e);
      });
      window.location.reload();
    }
  });
  mdScreenSizeActive(mdScreenSize);
  /**
  * Header Fixed On Scroll
  */
  window.addEventListener('scroll', () => {
    const fixedHeader = document.querySelector('.header')
    if (fixedHeader) {
      const headerTop = fixedHeader.offsetHeight;
      const scrolled = window.scrollY;
      const headerFixed = () => {
        if (scrolled > headerTop) {
          body.classList.add('header-crossed')
        } else if (scrolled < headerTop) {
          body.classList.remove('header-crossed')
        } else {
          body.classList.remove('header-crossed')
        }
      }
      headerFixed()
    }
  })
  /**
  * Range Value
  */
  const rangeInputs = document.querySelectorAll('input[type="range"]');
  function handleInputChange(e) {
    let target = e.target
    const min = target.min
    const max = target.max
    const val = target.value

    target.style.backgroundSize = (val - min) * 100 / (max - min) + '% 100%'
  }
  rangeInputs.forEach(input => {
    input.addEventListener('input', handleInputChange)
  })
  /**
  * Mouse Hover Effects
  */
  const circleBtn = document.querySelectorAll('.circle-btn')
  if (circleBtn) {
    circleBtn.forEach((element) => {
      element.addEventListener('mousemove', (e) => {
        const x = e.offsetX + 'px';
        const y = e.offsetY + 'px';
        element.style.setProperty('--x', x);
        element.style.setProperty('--y', y);
      })
    })
  }
  /**
  * Favorite Property
  */
  const favProperty = document.querySelectorAll('.property-card__heart')
  favProperty.forEach((e) => {
    e.addEventListener('click', () => {
      e.classList.toggle('solid')
    })
  })
  /**
  * Property Card Slider
  */
  const propertySlider = document.querySelectorAll('.property-card-slider')
  if (propertySlider) {
    propertySlider.forEach((e) => {
      const propertySliderInit = new Swiper(e, {
        loop: true,
        pagination: {
          el: '.property-card-pagination',
        },
        navigation: {
          nextEl: '.property-card-next',
          prevEl: '.property-card-prev',
        },
      })
    })
  }
  /**
  * Team Member Slider
  */
  const authorSlider = document.querySelector('.auth-slider');
  if (authorSlider) {
    const authorSliderInit = new Swiper(authorSlider, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 24,
      navigation: {
        nextEl: '.auth-slider__next',
        prevEl: '.auth-slider__prev',
      },
      breakpoints: {
        576: {
          slidesPerView: 2
        },
        768: {
          slidesPerView: 3
        },
        1200: {
          slidesPerView: 4
        }
      }
    })
  }
  /**
  * Testimonial Slider
  */
  const testimonialSlider = document.querySelector('.testimonial-slider__init')
  if (testimonialSlider) {
    const testimonialSliderInit = new Swiper(testimonialSlider, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 24,
      navigation: {
        nextEl: '.testimonial-slider__next',
        prevEl: '.testimonial-slider__prev',
      }
    })
  }
  /**
  * Discover New Location Slider
  */
  const locationSlider = document.querySelector('.location-slider');
  if (locationSlider) {
    const locationSliderInit = new Swiper(locationSlider, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 16,
      centeredSlides: true,
      centeredSlidesBounds: true,
      pagination: {
        el: '.location-slider__pagination',
        type: 'bullets',
        clickable: true
      },
      breakpoints: {
        768: {
          slidesPerView: 2.5
        },
        992: {
          slidesPerView: 3
        },
        1200: {
          slidesPerView: 3.5
        },
        1400: {
          slidesPerView: 4.5
        }
      }
    })
  }
  /**
  * Location Video
  */
  const lightbox = GLightbox({
    selector: '.location-slider__play',
    autoplayVideos: false
  });
  /**
  * Property Gallery
  */
  const propertyLightBox = GLightbox({
    selector: '.property-gallery',
    autoplayVideos: false
  });
  /**
  * Video Popup
  */
  const videoPopup = GLightbox({
    selector: '.video-popup',
    autoplayVideos: false
  });
  /**
  * Counter Up
  */
  const counterUp = window.counterUp.default
  const callback = entries => {
    entries.forEach(entry => {
      const el = entry.target
      if (entry.isIntersecting) {
        counterUp(el, {
          duration: 1000,
          delay: 16,
        })
      }
    })
  }
  const IO = new IntersectionObserver(callback, { threshold: 1 })
  const counterElement = document.querySelectorAll('.counter-up')
  counterElement.forEach((element) => {
    IO.observe(element)
  })
  /**
  * Testimonial Slider 2
  */
  const testimonialSliderTwo = document.querySelector('.testimonial-slider-two')
  if (testimonialSliderTwo) {
    const testimonialSliderTwoInit = new Swiper(testimonialSliderTwo, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 16,
      navigation: {
        nextEl: '.testimonial-slider-two__btn-next',
        prevEl: '.testimonial-slider-two__btn-prev',
      },
      breakpoints: {
        992: {
          slidesPerView: 2,
          spaceBetween: 24
        }
      }
    })
  }
  /**
  * Team Slider
  */
  const teamSlider = document.querySelector('.team-slider')
  if (teamSlider) {
    const teamSliderInit = new Swiper(teamSlider, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 16,
      pagination: {
        el: '.team-slider__pagination',
        clickable: true
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
          spaceBetween: 24
        },
        992: {
          slidesPerView: 3
        },
        1200: {
          slidesPerView: 4
        },
        1400: {
          slidesPerView: 4,
          spaceBetween: 24
        }
      }
    })
  }
  /**
  * Accordion
  */
  const accordionHeader = document.querySelectorAll('.custom-accordion__header');
  accordionHeader.forEach(header => {
    header.addEventListener('click', function () {
      const body = this.nextElementSibling;
      if (body.style.maxHeight) {
        body.style.maxHeight = null;
      } else {
        body.style.maxHeight = body.scrollHeight + 'px';
      }
    });
  });
  /**
  * Range Slider
  */
  const range = document.querySelectorAll(".range-slider__input");
  let progress = document.querySelector(".range-slider__progress");
  let gap = 0.1;
  const inputValue = document.querySelectorAll(".range-slider__value input");

  range.forEach((input) => {
    input.addEventListener("input", (e) => {
      let minRange = parseInt(range[0].value);
      let maxRange = parseInt(range[1].value);

      if (maxRange - minRange < gap) {
        if (e.target.className === "range-slider__min") {
          range[0].value = maxRange - gap;
        } else {
          range[1].value = minRange + gap;
        }
      } else {
        progress.style.left = (minRange / range[0].max) * 100 + "%";
        progress.style.right = 100 - (maxRange / range[1].max) * 100 + "%";
        inputValue[0].value = minRange;
        inputValue[1].value = maxRange;
      }
    });
  });
  /**
  * Property Gallery Slider
  */
  const propertyGallerySlider = document.querySelector('.property-gallery-slider');
  if (propertyGallerySlider) {
    new Swiper(propertyGallerySlider, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 16,
      centeredSlides: true,
      centeredSlidesBounds: true,
      navigation: {
        nextEl: '.property-gallery-slider__btn-next',
        prevEl: '.property-gallery-slider__btn-prev',
      },
      breakpoints: {
        576: {
          slidesPerView: 2.25
        },
        768: {
          slidesPerView: 2.5
        },
        1200: {
          slidesPerView: 3.25
        }
      }
    })
  }
  /**
  * Quantity Increment & Decrement
  */
  const guestQtyInc = document.querySelectorAll('.quantity__button-up');
  const guestQtyDec = document.querySelectorAll('.quantity__button-down');

  if (guestQtyInc || guestQtyDec || guestQtyVal) {

    guestQtyInc.forEach((e) => {
      e.addEventListener('click', (event) => {
        const buttonClicked = event.target;
        const guestInput = buttonClicked.parentElement.children[1]
        const guestInputValue = guestInput.value
        const newGuestInputValue = parseInt(guestInputValue) + 1
        guestInput.value = newGuestInputValue
      })
    })
    guestQtyDec.forEach((e) => {
      e.addEventListener('click', (event) => {
        const buttonClicked = event.target;
        const guestInput = buttonClicked.parentElement.children[1]
        const guestInputValue = guestInput.value
        isNaN(guestInputValue) ? 0 : guestInputValue;
        if (guestInputValue >= 1) {
          const newGuestInputValue = parseInt(guestInputValue) - 1
          guestInput.value = newGuestInputValue
        }
      })
    })
  }
  /**
  * Recent View Slider
  */
  const recentViewSlider = document.querySelector('.recent-view-slider')
  if (recentViewSlider) {
    new Swiper(recentViewSlider, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 24,
      navigation: {
        nextEl: '.recent-view-slider__btn-next',
        prevEl: '.recent-view-slider__btn-prev',
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
          spaceBetween: 16,
        },
        1200: {
          slidesPerView: 3
        },
        1200: {
          slidesPerView: 3,
          spaceBetween: 24
        }
      }
    })
  }
  /**
  * Brand Slider
  */
  const brandSlider = document.querySelector('.brand-slider')
  if (brandSlider) {
    new Swiper(brandSlider, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 20,
      breakpoints: {
        375: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3
        },
        992: {
          slidesPerView: 4,
        },
        1200: {
          slidesPerView: 6,
          centeredSlides: true,
          centeredSlidesBounds: true
        },
        1920: {
          slidesPerView: 7,
          centeredSlides: true,
          centeredSlidesBounds: true
        }
      }
    })
  }
  /**
  * Service Slider
  */
  const serviceSlider = document.querySelector('.service-slider')
  if (serviceSlider) {
    const serviceSliderInit = new Swiper(serviceSlider, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 24,
      pagination: {
        el: '.service-slider__pagination',
        clickable: true
      },
      breakpoints: {
        768: {
          slidesPerView: 2
        },
        992: {
          slidesPerView: 3
        }
      }
    })
  }
  /**
  * Blog Details Slider
  */
  const blogDetailsSlider = document.querySelector('.blog-details-slider')
  if (blogDetailsSlider) {
    const blogDetailsSliderInit = new Swiper(blogDetailsSlider, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 24,
      navigation: {
        nextEl: '.blog-details-slider__btn-next',
        prevEl: '.blog-details-slider__btn-prev',
      },
    })
  }
  /**
  * Discount Slider
  */
  const discountSlider = document.querySelector('.discount-slider')
  if (discountSlider) {
    const discountSliderInit = new Swiper(discountSlider, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 24,
      breakpoints: {
        768: {
          slidesPerView: 2
        }
      }
    })
  }
  /**
  * Choice Slider
  */
  const choiceSlider = document.querySelector('.choice-slider')
  if (choiceSlider) {
    const choiceSliderInit = new Swiper(choiceSlider, {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 8,
      navigation: {
        nextEl: '.choice-slider__btn-next',
        prevEl: '.hoice-slider__btn-prev',
      },
      breakpoints: {
        768: {
          slidesPerView: 2
        },
        992: {
          slidesPerView: 3
        },
      }
    })
  }
  /**
  * Image Upload
  */
  const imagePreview = document.getElementById('imagePreview');
  const imageUpload = document.getElementById('imageUpload');
  if (imagePreview || imageUpload) {
    function readURL(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imagePreview.style.backgroundImage = 'url(' + e.target.result + ')';
          imagePreview.style.display = 'none';
          imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    imageUpload.addEventListener('change', function () {
      readURL(this);
    });
  }
});

/**
* Preloader
*/
const preloader = document.querySelector('.preloader')
if (preloader) {
  window.onload = () => {
    preloader.style.display = "none"
  }
}









