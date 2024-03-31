// api.js
//import axios
import axios from 'axios';

// Login endpoint pakai axios
async function login(email, password) {
    email = email.toLowerCase();
    const response = await axios.post('http://127.0.0.1:8000/api/auth/login', {
        email,
        password
    });

    if (response.status === 200) {
        const data = response.data;
        localStorage.setItem('token', data.access_token);
        localStorage.setItem('exp', data.expires_in);
        // You can store other user data in localStorage as well
        // localStorage.setItem('user', JSON.stringify(data.user));
        console.log(localStorage);
        return data;
    }else{
        console.log(response);
        throw new Error('Login failed');
    }
}

// Register endpoint
async function register(username, password) {
    const response = await fetch('http://127.0.0.1:8000/api/auth/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password })
    });

    if (response.ok) {
        const data = await response.json();
        return data;
    } else {
        throw new Error('Registration failed');
    }
}

// Logout endpoint
function logout() {
    localStorage.removeItem('token');
    // You can remove other user data from localStorage as well
    // localStorage.removeItem('user');
}

export { login, register, logout };