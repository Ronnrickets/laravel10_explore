<template>
    <div>
      <v-container fluid fill-height>
          <v-layout align-center justify-center>
            <v-card
              outlined
              elevation="4"
              class="ma-1 fade-in-text"
              width="600px"
              style="border: 1px solid #030e12; border-radius:10px; background-color: #ffffff"
            >
              <v-row class="ma-0">
                <div style="background-color: black;">
                    <v-row style="text-align: center; margin-top: 40px" dense>
                      <v-col class="mt-10">
                        <img
                          draggable="false"
                          height="250px"
                          :src="'images/cabLOGO.PNG'"
                        />
                      </v-col>
                    </v-row>
                </div>
                <v-col>
                  <v-row>
                    <v-col>
                      <h2
                        class="noselect mt-4"
                        style="color:#B621FE; font-weight:bold; text-align:center; text-shadow: 2px 2px #000000;"
                      >
                        CAB SERVICE MANAGEMENT SYSTEM
                      </h2>
                    </v-col>
                  </v-row>
  
                  <v-row class="mt-3 mb-n8" >
                    <v-col>
                      <v-text-field
                        dense
                        outlined
                        color="#000000"
                        class="maintheme inputtext"
                        label="UserName"
                        prepend-inner-icon="mdi-account-circle"
                        :disabled="isLoading"
                        :error="credentials.UserCodeError.length > 0"
                        :error-messages="credentials.UserCodeError.length > 0 ? credentials.UserCodeError : ''"
                        v-model="credentials.UserCode"
                        @keyup.enter="login()"
                      />
                    </v-col>
                  </v-row>
  
                  <v-row class="mb-n5">
                    <v-col>
                      <v-text-field
                        dense
                        outlined
                        class="inputtext"
                        label="Password"
                        prepend-inner-icon="mdi-onepassword"
                        color="#000000"
                        :type="isShowPassword ? 'text' : 'password'"
                        :disabled="isLoading"
                        :error="credentials.PasswordError.length > 0"
                        :error-messages="credentials.PasswordError.length > 0 ? credentials.PasswordError : ''"
                        v-model="credentials.Password"
                        @keyup.enter="login()"
                      >
                        <!-- <v-tooltip right slot="append">
                          <template v-slot:activator="{ on, attrs }">
                            <v-icon
                              dark
                              v-on="on"
                              v-bind="attrs"
                              color="#000000"
                              @click="isShowPassword = !isShowPassword"
                            >
                              {{ !isShowPassword ? "mdi-eye-off" : "mdi-eye" }}
                            </v-icon>
                          </template>
                          <span>{{
                            isShowPassword ? "Hide Password" : "Show Password"
                          }}</span>
                        </v-tooltip> -->
                      </v-text-field>
                    </v-col>
                  </v-row>
  
                  <v-row class="mt-n3 mb-3" dense>
                    <v-spacer />
                    <v-col cols="12">
                      <v-btn
                        dark
                        block
                        color="#000000"
                        class="mt-n1"
                        :loading="isLoading"
                        @click="login()"
                      >
                        <h5 style="color:#FFFFF0">Login</h5>
                      </v-btn>
                    </v-col>
                  </v-row> 
                  <hr>
                  <v-row dense>
                    <v-col cols="12">
                        <h5 style="text-align:center; color:black; margin-top: 10px">No Account yet?</h5>
                        <v-btn 
                        dark 
                        block
                        color="#000000"
                        @click="SignUp()"
                        >
                          <h5 style="color:#FFFFF0">Create Account</h5>
                        </v-btn>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
            </v-card>
          </v-layout>
        </v-container>
    </div>
  </template>
  
  <script>
  import { mapState } from 'vuex';
    export default {
      data: () => ({
        isLoading: false,
        isShowPassword: false,
        credentials: {
          UserCode: "",
          Password: "",
          UserCodeError: "",
          PasswordError: "",
        },
        notificationSystem: {
            options: {
                toastpositions: {
                    position: "bottomRight"
                },
            }  
        },
      }),
      
      computed :{
        ...mapState(['session','userinfo']),
      },
  
      methods:{
        SignUp(){
          this.$router.push('signup')
        },
  
        login(){
          this.isLoading = true
          this.credentials.UserCodeError = ''
          this.credentials.PasswordError = ''
          axios.post(`${this.$url}/api/login`, this.credentials)
          .then(res => {
            this.$store.commit('login', res.data.userinfo[0])
            this.$toast.success(res.data.userinfo[0].Name, 'WELCOME', this.notificationSystem.options.toastpositions) 
            this.$store.state.userinfo.TypeName == 'Customer' ? this.$router.push('reservation') : this.$router.push('users')
          }).catch(({ response }) => {
            if(response){
              if(response.status == 404){
                // Returning of validation for text fields
                let keys = Object.keys(response.data);
                keys.forEach((key) => {
                  let field = key.includes("Error") ? key : `${key}Error`;
                  this.credentials[field] = response.data[key];
                });
              }else{
                // Returning of Error Page
                this.$store.commit('setStatusCode', response.status)
                this.$router.push("/error/" + response.status)
              }
            }
          }).finally(() => {
            this.isLoading = false
          })
        }
      }
    }
  </script>
  
  <style scoped>
    .noselect {
      -webkit-touch-callout: none; /* iOS Safari */
      -webkit-user-select: none; /* Safari */
      -khtml-user-select: none; /* Konqueror HTML */
      -moz-user-select: none; /* Old versions of Firefox */
      -ms-user-select: none; /* Internet Explorer/Edge */
      user-select: none; /* Non-prefixed version, currently */
    }
  
  </style>