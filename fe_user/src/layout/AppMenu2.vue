<script setup>
import { ref } from "vue";
import router from "@/router";
import { learnNow } from "@/api/index";

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
    label: "Course Item",
    items: [],
  },
]);

//buat const course_data
const course_data = ref({
  babs: [],
});

//panggil fungsi learnNow
learnNow()
  .then((response) => {
    course_data.value = response;
    console.log(course_data.value);
  })
  .catch((error) => {
    console.log(error);
  });

//fungsi gotocourse
const gotocourse = (id) => {
  //pushrouter ke learnId
  router.push({ name: "learnId", params: { id: id } });
};
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

  <!--ordered list berisi link -->

  <div
    v-for="(item, index) in course_data.babs"
    :key="item.id"
    class="dropdown"
  >
    <button
      type="button"
      class="btn btn-sm btn-outlined-success dropdown-toggle"
      data-bs-toggle="dropdown"
    >
      {{ index + 1 }}. {{ item.name }}
    </button>
    <ul class="dropdown-menu">
      <li v-for="(item2, index2) in item.materi">
        <a class="dropdown-item" href="#" @click="gotocourse(item2.id)">{{
          item2.name
        }}</a>
      </li>
    </ul>
  </div>
</template>

<style lang="scss" scoped></style>
