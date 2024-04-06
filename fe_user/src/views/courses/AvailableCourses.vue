<template>
  <div class="card">
    <h4>Available Courses</h4>
  </div>
  <div class="card">
    <div class="row">
      <div class="card-block">
        <div class="row" id="sortable">
          <div
            v-for="(item, index) in list_courses"
            class="col-md-3"
            style="margin-right: 10px; margin-bottom: 50px"
            key="index"
          >
            <div class="card-sub">
              <img
                class="card-img-top img-fluid h11 w11"
                src="http://localhost:5173/course.png"
                alt="Card image cap"
              />
              <div class="card-block">
                <h4 class="card-title">{{ item.name }}</h4>
                <span class="card-text">Rp {{ formatRupiah(item.price) }}</span
                ><br />
                <span class="card-text">Instruktur : {{ item.instructor }}</span
                ><br /><br />
                <!--button Course Detail dengan icon mata-->
                <div class="d-grid gap-2">
                  <button
                    @click="see(item.id)"
                    class="btn btn-outline-success btn-sm"
                    type="button"
                  >
                    <!--icon mata-->
                    <i class="pi pi-eye"></i>
                    See Course Detail
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
//import api
import { listCourses } from "@/api/index";
export default {
  data() {
    return {
      list_courses: [],
    };
  },
  methods: {
    get_list_courses() {
      listCourses()
        .then((response) => {
          this.list_courses = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    see(id) {
      this.$router.push({ name: "course_detail", params: { id: id } });
    },
    //fungsi untuk merubah nomor ke format rupiah
    formatRupiah(angka) {
      var number_string = angka.toString(),
        sisa = number_string.length % 3,
        rupiah = number_string.substr(0, sisa),
        ribuan = number_string.substr(sisa).match(/\d{3}/g);

      if (ribuan) {
        var separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
      }

      return rupiah;
    },
  },
  mounted() {
    ///list courses
    this.get_list_courses();
  },
};
</script>

<style scoped>
/* Tambahkan gaya CSS di sini */
</style>
