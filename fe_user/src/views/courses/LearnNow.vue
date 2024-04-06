<template>
  <div class="card">
    <h4>{{ data_kursus.course.name }}</h4>
  </div>
  <div class="card">
    <!--div if data_kursus.materi.jenis === "text" -->
    <div v-if="data_kursus.materi.materi.jenis === 'text'">
      <p>
        <!--agar tag html terbaca sebagaimana mestinya-->
        <div v-html="data_kursus.materi.materi.isi"></div>
      </p>


    </div>
  </div>
</template>

<script>
//import learNow
import { learnNow } from "@/api/index";
export default {
  data() {
    return {
      data_kursus: {
        course: {
          name: "",
        },
        materi: {
          materi : {
            jenis: "",
            isi: "",
          }
        },
      },
    };
  },
  methods: {
    loadDataKursus() {
      learnNow()
        .then((response) => {
          this.data_kursus = response;
          console.log(this.data_kursus);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    // Tambahkan logika yang akan dijalankan setelah komponen dipasang di DOM
    this.loadDataKursus();
  },
};
</script>

<style>
/* Tambahkan gaya CSS di sini */
</style>
