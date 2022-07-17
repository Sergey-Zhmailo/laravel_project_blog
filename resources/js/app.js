import './bootstrap';

import '../sass/app.scss';
import '../css/app.css';

import * as bootstrap from 'bootstrap';


// Toasts
const toastElList = document.querySelectorAll('.toast')
const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl))
toastList.forEach(item => {
    item.show();
});
