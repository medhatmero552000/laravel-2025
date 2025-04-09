import './bootstrap';
import Swal from 'sweetalert2';
window.Swal = Swal;
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
<script src="{{ mix('js/app.js') }}"></script>
