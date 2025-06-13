const toggle = document.getElementById('menu-toggle');
const navLinks = document.getElementById('nav-links');

toggle.addEventListener('click', () => {
  navLinks.classList.toggle('active');
});



 const counterEl = document.getElementById('counter');
    let current = 1;
    const max = 18743;

    function fastCount() {
      const batchSize = 100; // number of counts per frame
      for (let i = 0; i < batchSize && current <= max; i++) {
        counterEl.innerText = current;
        current++;
      }
      if (current <= max) {
        requestAnimationFrame(fastCount); // call again as fast as possible
      }
    }
    fastCount();


 
 
   function openModal(id) {
  document.getElementById(id).style.display = "block";
}
function closeModal(id) {
  document.getElementById(id).style.display = "none";
}
window.onclick = function(e) {
  if (e.target.classList.contains('modal')) e.target.style.display = "none";
}

// Form submit helper
async function sendData(url, data) {
  const res = await fetch(url, {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify(data)
  });
  return res.json();
}

// Signup form
document.getElementById("signupForm").addEventListener("submit", async function(e) {
  e.preventDefault();
  const f = this;
  const errorBox = document.getElementById("signupError");

  const data = {
    name: f.name.value.trim(),
    phone: f.phone.value.trim(),
    nationality: f.nationality.value,
    email: f.email.value.trim(),
    password: f.password.value,
    confirmPassword: f.confirmPassword.value
  };

  if (data.password !== data.confirmPassword) {
    errorBox.textContent = "Passwords do not match.";
    return;
  }

  try {
    const res = await sendData("signup.php", data);
    if (res.success) {
      alert(res.message);
      f.reset();
      closeModal('signupModal');
    } else {
      errorBox.textContent = res.message;
    }
  } catch {
    errorBox.textContent = "Server error. Try again.";
  }
});

// Login form
document.getElementById("loginForm").addEventListener("submit", async function(e) {
  e.preventDefault();
  const f = this;
  const errorBox = document.getElementById("loginError");

  const data = {
    email: f.email.value.trim(),
    password: f.password.value
  };

  try {
    const res = await sendData("login.php", data);
    if (res.success) {
      alert(res.message);
      f.reset();
      closeModal('loginModal');
    } else {
      errorBox.textContent = res.message;
    }
  } catch {
    errorBox.textContent = "Server error. Try again.";
  }
});
