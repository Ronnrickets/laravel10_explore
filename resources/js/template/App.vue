<template>
  <v-app>
    <v-navigation-drawer app v-model="drawer">
      <v-list dense>
        <v-list-group>
          <v-list-item
            v-for="(item, i) in items"
            :key="i"
            :to="item.to"
            :prepend-icon="item.icon"
          >
            <v-list-item-title >{{ item.title }}</v-list-item-title>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-icon @click="drawer = !drawer">mdi-menu</v-icon>
      <v-toolbar-title>My Application</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      drawer: null,
      items: [
        { title: 'Home', value: 'home', to: '/home', icon: 'mdi-home-city' },
        { title: 'My Account', value: 'account', to: '/account', icon: 'mdi-account' },
        { title: 'Users', value: 'users', to: '/users', icon: 'mdi-account-group-outline' },
      ],
    };
  },
};
</script>