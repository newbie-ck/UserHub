<template>
    <div class="text-center vh-100 d-flex flex-column justify-content-center">
        <h1 class="mb-4">User Login</h1>
        <form @submit.prevent="login" class="w-50 mx-auto">
            <div class="form-outline mb-4">
                <input ref="usernameInput" type="text" v-model="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-outline mb-4">
                <input type="password" v-model="password" class="form-control" placeholder="Password" required>
            </div>
            <p class="text-danger text-start mb-4" v-if="err">{{ err }}</p>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            
            <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" v-model="remember" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember Me</label>
                </div>
                <div>
                    <span class="mr-2">Don't have an account?   </span>
                    <a href="/register" class="text-decoration-none">Register</a>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    mounted() {
        this.$refs.usernameInput.focus();
    },

    data() {
        return {
            name: '',
            email: '',
            username: '',
            password: '',
            phone_number: '',
            err: '',
            remember: false,
        }
    },

    methods: {
        login() {
            // Validate form inputs
            if (!this.username || !this.password) {
                // Display error message if any field is empty
                alert('Please fill in all fields');
                return;
            }

            // Assuming validation passes, send form data to server
            const formData = {
                username: this.username,
                password: this.password,
                remember: this.remember,
            };

            // Example of sending form data using axios library
            axios.post('/login', formData)
                .then(response => {
                    // Handle success response
                    alert('Login successful!');
                    this.err = ''
                    // Refresh the page
                    window.location.reload();
                })
                .catch(error => {
                    // Handle error response
                    alert('Login failed. Please try again later.');
                    this.err = error.response.data.error
                    console.error(error);
                });
        },
    }
}
</script>