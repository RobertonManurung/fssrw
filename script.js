document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah pengiriman form
    // Logika untuk memproses login
    alert('Login berhasil!');
});

document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah pengiriman form
    // Logika untuk memproses registrasi
    const password = document.getElementById('registerPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password === confirmPassword) {
        alert('Registrasi berhasil!');
    } else {
        alert('Password tidak cocok!');
    }
});
