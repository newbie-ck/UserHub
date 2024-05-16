<template>
    <div class="container mt-5">
        <!-- Odometer to display total registered users -->
        <div class="d-flex align-items-center">
            <h3>Total registered users: </h3>
            <vue3Odometer class="ms-3 odometer" :value="totalUsers" />
        </div>
        
        <div class="card mt-5">
            <div class="card-body">
                <h5 class="card-title">User List</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th @click="sortBy('id')" class="cursor-pointer">
                                ID
                                <i v-if="sortByColumn === 'id'" :class="sortDirection === 'asc' ? 'bi bi-sort-up' : 'bi bi-sort-down-alt'"></i>
                            </th>
                            <th @click="sortBy('name')" class="cursor-pointer">
                                Name
                                <i v-if="sortByColumn === 'name'" :class="sortDirection === 'asc' ? 'bi bi-sort-up' : 'bi bi-sort-down-alt'"></i>
                            </th>
                            <th @click="sortBy('email')" class="cursor-pointer">
                                Email
                                <i v-if="sortByColumn === 'email'" :class="sortDirection === 'asc' ? 'bi bi-sort-up' : 'bi bi-sort-down-alt'"></i>
                            </th>
                            <th @click="sortBy('phone_number')" class="cursor-pointer">
                                Phone Number
                                <i v-if="sortByColumn === 'phone_number'" :class="sortDirection === 'asc' ? 'bi bi-sort-up' : 'bi bi-sort-down-alt'"></i>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id" :class="{ 'table-danger': !user.is_active }">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.phone_number }}</td>
                            <td>
                                <!-- Edit icon -->
                                <i class="bi bi-pencil cursor-pointer" @click="editUser(user)"></i>
                                <!-- Deactivate icon -->
                                <i v-if="user.is_active" class="bi bi-x-circle ms-3 cursor-pointer" @click="showConfirmationModal('deactivate', user)"></i>
                                <i v-else class="bi bi-check-circle ms-3 cursor-pointer" @click="showConfirmationModal('activate', user)"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav aria-label="Pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <button class="page-link" @click="prevPage" :disabled="currentPage <= 1">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                        </li>
                        <li class="page-item">
                            <span class="page-link">{{ currentPage }}</span>
                        </li>
                        <li class="page-item">
                            <button class="page-link" @click="nextPage" :disabled="currentPage >= totalPages">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="modal userhub-modal" tabindex="-1" role="dialog" v-if="showModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ action === 'activate' ? 'Activate User' : 'Deactivate User' }}</h5>
                        <button type="button" class="close close-button" data-dismiss="modal" aria-label="Close" @click="hideModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to {{ action === 'activate' ? 'activate' : 'deactivate' }} this user?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="hideModal">Cancel</button>
                        <button type="button" class="btn" :class="action === 'activate' ? 'btn-success' : 'btn-danger'" @click="toggleUserStatus(action)">{{ action === 'activate' ? 'Activate' : 'Deactivate' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import 'odometer/themes/odometer-theme-default.css'

export default {
    data() {
        return {
            users: [],
            currentPage: 1,
            totalPages: 1,
            sortByColumn: null,
            sortDirection: 'asc',
            totalUsers: 0,
            showModal: false,
            modifyUser: null,
        };
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        fetchUsers() {
            axios.get('data/users', {
                params: {
                    page: this.currentPage,
                    sort_by: this.sortByColumn,
                    sort_dir: this.sortDirection
                }
            }).then(response => {
                this.users = response.data.data;
                this.currentPage = response.data.current_page;
                this.totalPages = response.data.last_page;
                this.totalUsers = response.data.total
            }).catch(error => {
                console.error(error);
            });
        },

        sortBy(column) {
            if (column === this.sortByColumn) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortByColumn = column;
                this.sortDirection = 'asc';
            }
            this.fetchUsers();
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.fetchUsers();
            }
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.fetchUsers();
            }
        },

        editUser(user) {
           window.location.href = `users/${user.id}`
        },

        toggleUserStatus(action) {
            const endpoint = action === 'activate' ? `users/activate/${this.modifyUser.id}` : `users/deactivate/${this.modifyUser.id}`;
            axios.put(endpoint, this.modifyUser)
                .then(response => {
                    alert(response.data.message);
                    this.fetchUsers();
                })
                .catch(error => {
                    console.error(error);
                    alert(error.response.data.error);
                });
            this.hideModal();
        },

        showConfirmationModal(action, user) {
            this.action = action;
            this.modifyUser = user;
            this.showModal = true;
        },

        hideModal() {
            this.showModal = false;
            this.modifyUser = null;
        }
    }
}
</script>