// form


// form validation
const forms = document.querySelectorAll('.needs-validation')

// Loop over them and prevent submission
Array.from(forms).forEach(form => {
  form.addEventListener('submit', event => {
    if (!form.checkValidity()) {
      event.preventDefault()
      event.stopPropagation()
    }

    form.classList.add('was-validated')
  }, false)
})



//============ password hide or show =========
// let passwordInput = document.getElementById('accountPass'),
//   toggle = document.getElementById('btnToggle'),
//   icon = document.getElementById('eyeIcon');

// function togglePassword() {
//   if (passwordInput.type === 'password') {
//     passwordInput.type = 'text';
//     icon.classList.add("lni-eye slash");
//     //   toggle.innerHTML = 'hide';
//   } else {
//     passwordInput.type = 'password';
//     icon.classList.remove("lni-eye");
//     //   toggle.innerHTML = 'show';
//   }
// }


function togglePassword(type) {
  console.log('type');
  var passwordInput = document.getElementById('accountPass');
  var toggleBtn = document.getElementById('btnToggle');

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    icon.classList.add("lni-eye slash");
  } else {
    passwordInput.type = 'password';
    con.classList.remove("lni-eye");
  }
}


function checkInput() {
  if (passwordInput.value === '') {
    toggle.style.display = 'none';
    toggle.innerHTML = 'show';
    passwordInput.type = 'password';
  } else {
    toggle.style.display = 'block';
  }
}
