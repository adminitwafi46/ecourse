<script setup>
import { ref } from "vue";

import AppMenuItem from "./AppMenuItem.vue";

const model = ref([
  {
    label: "Home",
    items: [{ label: "Dashboard", icon: "pi pi-fw pi-home", to: "/" }],
  },
  {
    label: "Courses",
    items: [
      {
        label: "List Kursus",
        icon: "pi pi-fw pi-id-card",
        to: "/available_courses",
      },
      {
        label: "My Courses",
        icon: "pi pi-fw pi-book",
        to: "/my_courses",
      },
    ],
  },

  {
    label: "Payment",
    items: [
      {
        label: "Tagihan",
        icon: "pi pi-fw pi-wallet",
        to: "/tagihan",
      },
    ],
  },
  {
    label: "User",
    items: [
      {
        label: "My Profile",
        icon: "pi pi-fw pi-user",
        to: "/profile",
      },
    ],
  },
]);
</script>

<template>
  <ul class="layout-menu">
    <template v-for="(item, i) in model" :key="item">
      <app-menu-item
        v-if="!item.separator"
        :item="item"
        :index="i"
      ></app-menu-item>
      <li v-if="item.separator" class="menu-separator"></li>
    </template>
  </ul>
</template>

<style lang="scss" scoped></style>
