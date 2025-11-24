import './bootstrap';
import Alpine from 'alpinejs';

// import sweetalert2 dari npm
import Swal from 'sweetalert2';
import "./sweetalert2";

// buat global
window.Swal = Swal;

window.Alpine = Alpine;
Alpine.start();

