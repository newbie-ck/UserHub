<template>
    <div class="text-center vh-100 d-flex flex-column justify-content-center">
        <h1 class="mb-4">Create a User Account</h1>
        <form @submit.prevent="register" class="w-50 mx-auto">
            <div class="form-group mb-4">
                <input type="text" v-model="name" class="form-control" placeholder="Name" required>
                <p class="text-start"><small class="text-danger" v-if="errors && errors.name">{{ errors.name[0] }}</small></p>
            </div>
            <div class="form-group mb-4">
                <input type="email" v-model="email" class="form-control" placeholder="Email" required>
                <p class="text-start"><small class="text-danger" v-if="errors && errors.email">{{ errors.email[0] }}</small></p>
            </div>
            <div class="form-group mb-4">
                <input type="text" v-model="username" class="form-control" placeholder="Username" required>
                <p class="text-start"><small class="text-danger" v-if="errors && errors.username">{{ errors.username[0] }}</small></p>
            </div>
            <div class="form-group mb-4">
                <input type="password" v-model="password" class="form-control" placeholder="Password" required>
                <p class="text-start"><small class="text-danger" v-if="errors && errors.password">{{ errors.password[0] }}</small></p>
            </div>
            <div class="form-group mb-4">
                <input type="password" v-model="confirm_password" class="form-control" placeholder="Confirm Password" required>
                <p class="text-start"><small class="text-danger" v-if="errors && errors.confirm_password">{{ errors.confirm_password[0] }}</small></p>
            </div>
            <div class="form-group mb-4">
                <input type="text" v-model="phone_number" class="form-control" placeholder="Phone Number" required>
                <p class="text-start"><small class="text-danger" v-if="errors && errors.phone_number">{{ errors.phone_number[0] }}</small></p>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign up</button>
            <div class="mt-2 text-end">
                <span class="mr-2">Already have an account?   </span>
                <a href="/login" class="text-decoration-none">Login</a>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            username: '',
            password: '',
            confirm_password: '',
            phone_number: '',
            errors: null,
        }
    },

    methods: {
        register() {
            const formData = {
                name: this.name,
                email: this.email,
                username: this.username,
                password: this.password,
                confirm_password: this.confirm_password,
                phone_number: this.phone_number
            };

            this.errors = null;

            // Example of sending form data using axios library
            axios.post('/register', formData)
                .then(response => {
                    // Handle success response
                    alert('Registration successful!');
                    // Reset form fields
                    this.resetForm();
                    window.location.href = '/login';
                })
                .catch(error => {
                    // Handle error response
                    alert('Registration failed. Please try again later.');
                    this.errors = error.response.data.errors
                    if (this.password != this.confirm_password) {
                        this.errors['confirm_password'] = ['Password and Confirm Password does not match']
                    }
                    console.error(error);
                });
        },

        resetForm() {
            this.name = '';
            this.email = '';
            this.username = '';
            this.password = '';
            this.confirm_password = '';
            this.phone_number = '';
            this.errors = null;
        },
    }
}
</script>