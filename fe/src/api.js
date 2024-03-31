// api.js

// Login endpoint
async function login(username, password) {
    const response = await fetch('http://127.0.0.1:8000/api/auth/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password })
    });

    if (response.ok) {
        const data = await response.json();
        localStorage.setItem('token', data.token);
        // You can store other user data in localStorage as well
        // localStorage.setItem('user', JSON.stringify(data.user));
        return data;
    } else {
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