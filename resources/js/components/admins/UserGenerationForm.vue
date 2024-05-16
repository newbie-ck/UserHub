<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">User Generation</div>
            <div class="card-body">
                <form @submit.prevent="generateUsers">
                    <div class="mb-3">
                        <label for="userCount" class="form-label">Enter the number of users to generate:</label>
                        <input type="number" class="form-control" id="userCount" v-model="userCount" required min="1">
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Users</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            userCount: 1
        };
    },
    methods: {
        generateUsers() {
           axios.post('/admin/dashboard/users/generate?number=' + this.userCount)
           .then(response => {
            this.onSuccess(response)
           })
           .catch(error => {
            this.onError(error);
          });
        },

        onSuccess(response) {
            alert(response.data.message);
        },

        onError(error) {
            alert(error.response.data.errors)
        },
    }
}
</script>