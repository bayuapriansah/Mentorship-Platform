// import './bootstrap';
import 'flowbite';

import Swiper, { Navigation, Pagination } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const swiperProject =  new Swiper('.swiper-project-container', {
    direction: 'vertical',
    slidesPerView: 'auto',
    spaceBetween: 10,
    navigation: {
    nextEl: '#swiper-project-button-next',
    prevEl: '#swiper-project-button-prev',
    }
});

const swiper = new Swiper('.swiper-container', {
    slidesPerView: 3,
    spaceBetween: 30,
    navigation: {
      nextEl: '#swiper-button-next',
      prevEl: '#swiper-button-prev',
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      480: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      640: {
        slidesPerView: 2,
        spaceBetween: 10,
      },
      950: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
    },
    modules: [Navigation, Pagination],
  });

  const swiperTestimonial = new Swiper('.swip-testimonial', {
    slidesPerView: 3,
    spaceBetween: 30,
    navigation: {
      nextEl: '#testimonial-swiper-button-next',
      prevEl: '#testimonial-swiper-button-prev',
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      480: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      640: {
        slidesPerView: 2,
        spaceBetween: 10,
      },
      950: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
    },
    modules: [Navigation, Pagination],
  });

document.addEventListener("DOMContentLoaded", function() {
    const textarea = document.getElementById('feedback');
    const counter = document.getElementById('counter');

    if (textarea && counter) {
        counter.textContent = `${textarea.value.length}/1000`;

        textarea.addEventListener('input', function() {
            counter.textContent = `${this.value.length}/1000`;

            if (this.value.length > 1000) {
                this.value = this.value.substring(0, 1000);
            }
        });
    }
});
//     const chatBox = document.getElementById('chat-box');
//     const userInput = document.getElementById('user-input');
//     const chatButton = document.getElementById('chat-button');
//     const chatContainer = document.getElementById('chat-container');
//     const closeChat = document.getElementById('close-chat');

//     closeChat.addEventListener('click', function() {
//         chatContainer.classList.add('hidden');
//     });

//     chatButton.addEventListener('click', function() {
//         if (chatContainer.classList.contains('hidden')) {
//             chatContainer.classList.remove('hidden');
//         } else {
//             chatContainer.classList.add('hidden');
//         }
//     });

//     userInput.addEventListener('keypress', function(e) {
//         if (e.key === 'Enter') {
//             e.preventDefault();
//             const message = userInput.value;
//             chatBox.innerHTML += `<div class="flex justify-end py-4">
//                         <i class="fa-solid fa-user mr-2 my-auto px-2"></i>
//                         <div class="user-message">${message}</div>
//                       </div>`;

//             userInput.value = '';

//             // Fetch CSRF token from meta tag
//             const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

//             fetch('/ask', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': csrfToken, // Use the fetched CSRF token
//                 },
//                 body: JSON.stringify({ message }),
//             })
//             .then(response => {
//                 console.log("Raw response:", response); // Log raw response
//                 return response.json();
//             })
//             .then(data => {
//                 console.log("Parsed data:", data); // Log parsed data
//                 chatBox.innerHTML += `<div class="flex justify-start py-4">
//                         <i class="fa-solid fa-robot mr-2 my-auto px-2"></i>
//                         <div class="bot-message bg-gray-800 text-white rounded">${data.reply}</div>
//                       </div>`;
//             })
//             .catch(error => {
//                 console.log("Fetch error:", error); // Log any exceptions
//             });
//         }
//     });
