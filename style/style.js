const doctorBtn = document.getElementById('doctorBtn');
const patientBtn = document.getElementById('patientBtn');
const adminBtn = document.getElementById('adminBtn');
const signup = document.getElementById('signup');
var current = "doctor"

patientBtn.classList.add('bg-white', 'shadow-md');
        

[doctorBtn, patientBtn, adminBtn].forEach(btn => {
    btn.addEventListener('click', function() {
        [doctorBtn, patientBtn, adminBtn].forEach(b => {
        b.classList.remove('bg-white', 'shadow-md');
    });
    if (this == patientBtn) {
        signup.style.visibility = "visible"
        } 
    else {
        signup.style.visibility = "hidden"
        }
    this.classList.add('bg-white', 'shadow-md');
    });
});
        

const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');
        
togglePassword.addEventListener('click', function() {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
            
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});
        

const inputs = document.querySelectorAll('.floating-input');
        
inputs.forEach(input => {
    if (input.value) {
        input.previousElementSibling.classList.add('-top-2', 'text-sm', 'text-blue-600');
    }
            
    input.addEventListener('focus', () => {
        input.previousElementSibling.classList.add('-top-2', 'text-sm', 'text-blue-600');
    });
            
    input.addEventListener('blur', () => {
        if (!input.value) {
            input.previousElementSibling.classList.remove('-top-2', 'text-sm', 'text-blue-600');
        }
    });
});