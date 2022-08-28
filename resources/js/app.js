import './bootstrap';

import '../sass/app.scss';
import '../css/app.css';

import * as bootstrap from 'bootstrap';

import Swiper, { Navigation, Pagination } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';


// Toasts
const toastElList = document.querySelectorAll('.toast')
const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl))
toastList.forEach(item => {
    item.show();
});

document.addEventListener('DOMContentLoaded', () => {
    // Post slider
    if (document.querySelector('.post-slider')) {
        const post_slider = new Swiper('.post-slider', {
            modules: [Navigation, Pagination],
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    }
});
