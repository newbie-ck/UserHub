<template>
    <div class="container mt-5">
      <div class="card">
        <div class="card-body" v-if="!canEdit">
          <h5 class="card-title">{{ user_name }}</h5>
          <p class="card-text mt-3">Phone: {{ user_phone_number }}</p>
          <p class="card-text">Email: {{ user_email }}</p>
          <button class="btn btn-primary" @click="editUser">Edit</button>
          <button class="btn btn-danger ms-2" @click="showDeactivateConfirmation">Deactivate</button>
        </div>
        <div class="card-body" v-else>
            <div class="mb-3">
                <label for="edit-name" class="form-label">Name</label>
                <input type="text" class="form-control" id="edit-name" v-model="editedUser.name">
                <p v-if="errors && errors.name"><small class="text-danger">{{ errors.name[0] }}</small></p>
            </div>
            <div class="mb-3">
                <label for="edit-phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="edit-phone" v-model="editedUser.phone_number">
                <p v-if="errors && errors.phone_number"><small class="text-danger" >{{ errors.phone_number[0] }}</small></p>
            </div>
            <div class="mb-3">
                <label for="edit-email" class="form-label">Email</label>
                <input type="email" class="form-control" id="edit-email" v-model="editedUser.email">
                <p v-if="errors && errors.email"><small class="text-danger" >{{ errors.email[0] }}</small></p>
            </div>
            <button class="btn btn-primary" @click="updateUser">Update</button>
            <button class="btn btn-secondary ms-2" @click="cancel">Cancel</button>
        </div>

        <div class="modal userhub-modal" tabindex="-1" role="dialog" v-if="showDeactivateModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Deactivate User</h5>
                <button type="button" class="close close-button" data-dismiss="modal" aria-label="Close" @click="hideDeactivateModal">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Are you sure you want to deactivate this user?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="hideDeactivateModal">Cancel</button>
                <button type="button" class="btn btn-danger" @click="deactivateUser">Deactivate</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: ['user'],
  
    data() {
      return {
        editedUser: {
            id: this.user.id,
            name: this.user.name,
            phone_number: this.user.phone_number,
            email: this.user.email
        },
        canEdit: false,
        errors: null,
        showDeactivateModal: false
      }
    },
  
    methods: {
      editUser() {
        // Show the edit modal
        this.canEdit = true;
      },

      async updateUser() {
        axios.put(`/dashboard/update/${this.user.id}`, this.editedUser)
          .then(response => {
            alert(response.data.message);
            this.canEdit = false;
            this.errros = null;

          })
          .catch(error => {
            alert('Update failed. Please try again later.');
            this.errors = error.response.data.errors
            console.error(error);
          });
      },

      cancel() {
        this.canEdit = false;
        this.errors = null;
        this.editedUser = this.user
      },

      showDeactivateConfirmation() {
        this.showDeactivateModal = true;
      },

      hideDeactivateModal() {
        this.showDeactivateModal = false;
      },

      deactivateUser() {
        // Logic to deactivate the user goes here
        axios.put(`/dashboard/deactivate/${this.user.id}`, this.editedUser)
          .then(response => {
            alert(response.data.message);

            // Logout
            var form = document.getElementById('logout-form');
            form.submit();
          })
          .catch(error => {
            alert(error.response.data.error);
          });

        this.hideDeactivateModal();
      }
    },

    computed: {
      user_name() {
        return this.errors && this.errors.name ? this.user.name : this.editedUser.name;
      },

      user_phone_number() {
        return this.errors && this.errors.phone_number ? this.user.phone_number : this.editedUser.phone_number;
      },

      user_email() {
        return this.errors && this.errors.email ? this.user.email : this.editedUser.email;
      }
    }
  }
  </script>