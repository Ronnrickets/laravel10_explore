<template>
    <div>
        <v-row dense class="mt-3">
            <v-col cols="3">
                <v-text-field
                type="number"
                label="Search"
                density="compact"
                variant="outlined"
                />
            </v-col>
            <v-col cols="3">
                <v-btn @click="onAdd()">
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
            </v-col>
            <v-col cols="3">
                <v-btn @click="printPDF()">
                    EXPORT PDF
                </v-btn>
            </v-col>
        </v-row>
        <v-row dense class="mt-3">
            <v-col cols="12">
                <v-card elevation="5">
                    <v-table dense width="100%">
                    <thead>
                        <tr>
                            <th>Employee Code</th>
                            <th>Password</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item, i in usersArr" :key="i">
                            <td>{{ item.EmployeeCode }}</td>
                            <td>{{ item.Password }}</td>
                            <td>{{ item.UserName }}</td>
                            <td>{{ item.Email }}</td>
                            <td style="text-align:center;">
                                <v-icon color="green" @click="onEdit(item)">mdi-pencil</v-icon>
                                <v-icon color="red"  @click="deleteRestore(item)">mdi-trash-can</v-icon>
                            </td>
                            <td>
                                <span :style="'color: ' + (item.Status == 1 ? 'green' : 'red')">{{ item.Status == 1 ? 'Active' : 'Inactive'}}</span>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
                </v-card>
            </v-col>
        </v-row>

        <v-dialog persistent v-model="usersDialog" max-width="400px">
            <v-card>
                <v-toolbar color="blue">
                    <v-card-title>{{dialogTitle}} USERS</v-card-title>
                    <v-spacer/>
                    <v-icon color="red" class="mr-3" @click="usersDialog = false">mdi-close</v-icon>
                </v-toolbar>
                <v-card-text>
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field
                            label="Employee Code"
                            density="compact"
                            variant="outlined"
                            :disabled="dialogTitle == 'EDIT'"
                            v-model="toSaveObj.employeeCode"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                            label="Password"
                            density="compact"
                            variant="outlined"
                            v-model="toSaveObj.password"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                            label="UserName"
                            density="compact"
                            variant="outlined"
                            v-model="toSaveObj.username"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                            label="Email"
                            density="compact"
                            variant="outlined"
                            v-model="toSaveObj.email"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-btn block color="blue" @click="saveData()">
                                <span>SAVE</span>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                usersDialog: false,
                dialogTitle: '',
                toSaveObj:{
                    employeeCode: '',
                    password: '',
                    username: '',
                    email: '',
                },
                usersArr: []
            }
        },

        created(){
            this.getUsers()
        },

        methods: {
            getUsers(){
                axios.get(`api/users?condition=users`)
                .then(res => {
                    this.usersArr = res.data
                }).catch(err =>{
                    console.log(err);
                })
            },

            onAdd(){
                this.dialogTitle = 'ADD'
                this.usersDialog = true
            },

            onEdit(item){
                this.dialogTitle = 'EDIT'
                this.toSaveObj.employeeCode = item.EmployeeCode
                this.toSaveObj.password = item.Password
                this.toSaveObj.username = item.UserName
                this.toSaveObj.email = item.Email
                this.usersDialog = true
            },

            saveData(){
                if(this.dialogTitle == 'ADD'){
                    axios.post(`api/users`, this.toSaveObj)
                    .then(res => {
                        this.usersArr = res.data
                        this.usersDialog = false
                    }).catch(err =>{
                        console.log(err);
                    })
                }else{
                    axios.put(`api/users/editusers`, this.toSaveObj)
                    .then(res => {
                        this.usersArr = res.data
                        this.usersDialog = false
                    }).catch(err =>{
                        console.log(err);
                    })
                }
            },

            deleteRestore(item){
                this.toSaveObj.employeeCode = item.EmployeeCode
                this.toSaveObj.Status = item.Status
                axios.put(`api/users/deleterestore`, this.toSaveObj)
                    .then(res => {
                        this.usersArr = res.data
                        this.usersDialog = false
                    }).catch(err =>{
                        console.log(err);
                    })
            },

            printPDF(){
                window.open(`api/users/createPDF`)
            }
        }
    }
</script>

<style scoped>
    table, tr, th,td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>