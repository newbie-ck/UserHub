require('./bootstrap');
import { createApp } from 'vue';
import Login from './components/LoginPage.vue';
import Registration from './components/RegistrationPage.vue';
import UserDetail from './components/users/UserDetail.vue';
import UserList from './components/admins/UserList.vue';
import UserGenerationForm from './components/admins/UserGenerationForm.vue';
import Vue3Odometer from 'vue3-odometer'
import NotAdminMessage from './components/NotAdminMessage.vue';

const app = createApp({});
app.component('login', Login);
app.component('registration', Registration)
app.component('user-detail', UserDetail)
app.component('user-list', UserList)
app.component('user-generation', UserGenerationForm)
app.component('vue3Odometer', Vue3Odometer)
app.component('not-admin-message', NotAdminMessage)

app.mount('#app');