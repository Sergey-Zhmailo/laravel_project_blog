import './bootstrap';

import '../sass/app.scss';
import '../css/app.css';

import * as bootstrap from 'bootstrap';

import Swiper from 'swiper';
import 'swiper/css';


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

        });
    }
});
