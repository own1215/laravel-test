<template>
    <div data-app>
        <div>
            <v-dialog
                    v-model="dialog"
                    width="500"
            >
                <v-btn slot="activator"
                       color="green lighten-2"
                       dark
                >Add new</v-btn>

                <v-card>
                    <v-card-title class="headline grey lighten-2" primary-title>
                        Add new user
                    </v-card-title>

                    <v-card-text>
                        <v-form v-model="valid">
                            <v-container>
                                <v-layout>
                                    <v-flex
                                            xs12
                                            md4
                                    >
                                        <v-text-field
                                                v-model="newUser.name"
                                                label="First name"
                                                required
                                        ></v-text-field>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            md4
                                    >
                                        <v-text-field
                                                v-model="newUser.email"
                                                label="E-mail"
                                                required
                                        ></v-text-field>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            md4
                                    >
                                        <v-text-field
                                                v-model="newUser.password"
                                                label="Password"
                                                required
                                        ></v-text-field>
                                    </v-flex>
                                </v-layout>
                                <div class="errors">
                                    <ul>
                                        <li v-if="formErrors.name">{{ formErrors.name[0] }}</li>
                                        <li v-if="formErrors.email">{{ formErrors.email[0] }}</li>
                                        <li v-if="formErrors.password">{{ formErrors.password[0] }}</li>
                                    </ul>
                                </div>
                            </v-container>
                        </v-form>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn v-if="!newUser.id"
                               color="primary"
                               flat
                               @click="addNewUser"
                        >Create</v-btn>
                        <v-btn v-if="newUser.id"
                               color="primary"
                               flat
                               @click="updateUser"
                        >Update</v-btn>
                        <v-btn color="primary"
                               flat
                               @click="cancelNewUser"
                        >Cancel</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
        <v-data-table
                :headers="headers"
                :items="userList"
                class="elevation-1"
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.item.name }}</td>
                <td class="text-xs-right">{{ props.item.email }}</td>
                <td class="text-xs-right">{{ props.item.created_at }}</td>
                <td class="text-xs-right">
                    <v-btn color="blue lighten-2"
                           dark
                           @click="editUser(props.item)"
                    >Edit</v-btn>

                    <v-btn color="red lighten-2"
                           dark
                           @click="removeUser(props.item.id)"
                    >Remove</v-btn>
                </td>
            </template>
        </v-data-table>

    </div>
</template>

<script>
    export default {
        name: "UserList",
        props:[
            'users',
        ],
        data () {
            return {
                headers: [
                    { text: 'Name', value: 'name' },
                    { text: 'Email', value: 'email' },
                    { text: 'Created at', value: 'created_at' },
                    { text: 'Actions' },
                ],
                userList: this.users,
                dialog: false,
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid'
                ],
                nameRules: [
                    v => !!v || 'Name is required',
                    v => v.length <= 30 || 'Name must be less than 30 characters'
                ],
                passRules: [
                    v => !!v || 'Password is required',
                    v => v.length <= 20 || 'Password must be less than 20 characters'
                ],
                newUser: {
                    name: '',
                    email: '',
                    password: '',
                },
                valid: false,
                formErrors: {
                    name: '',
                    email: '',
                    password: '',
                },
            }
        },
        methods: {
            async removeUser(id) {
                try {
                    await axios.delete(`/admin/users/${id}`);
                    this.userList = this.userList.filter(item => {
                        return item.id !== id;
                    });
                } catch(e) {}
            },
            async addNewUser() {
                this.setDefaultFromErrors();

                try {
                    let {data} = await axios.post('/admin/users', this.newUser);

                    this.userList = data;
                    this.setUserDefault();
                    this.dialog = false;

                } catch(e) {
                    this.formErrors = e.response.data.errors;
                }
            },
            cancelNewUser() {
                this.dialog = false;
                this.setUserDefault();
            },
            setUserDefault() {
                this.newUser = {
                    name: '',
                    email: '',
                    password: '',
                };
            },
            setDefaultFromErrors() {
                this.formErrors = {
                    name: '',
                    email: '',
                    password: '',
                };
            },
            editUser(props) {
                this.newUser = props;
                this.dialog = true;
            },
            async updateUser()
            {
                this.setDefaultFromErrors();

                try {
                    let {data} = await axios.put(`/admin/users/${this.newUser.id}`, this.newUser);

                    this.userList = data;
                    this.setUserDefault();
                    this.dialog = false;

                } catch(e) {
                    this.formErrors = e.response.data.errors;
                }
            }
        }
    }
</script>

<style scoped>
    .errors {
        color: red;
    }
</style>