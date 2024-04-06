<template></template>
<script>
//variabvel data_course, method dan mounted
import { dataCourse } from "@/api/index";
export default {
  data() {
    return {
      data_course: [],
    };
  },
  methods: {
    //method untuk mengambil data course
  },
  mounted() {
    // Tambahkan logika yang akan dijalankan setelah komponen dipasang di DOM
    //ambil dr parameter id
    const id = this.$route.params.id;
    dataCourse(id)
      .then((response) => {
        this.data_course = response;
        console.log(this.data_course);
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>
