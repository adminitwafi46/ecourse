<template>
  <div class="card">
    <h4>Kelola Kursus</h4>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="container">
        <div class="d-flex justify-content-center row">
          <div class="col-md-12">
            <div
              v-for="(kursus, index) in list_kursus.data"
              :key="index"
              class="row p-2 bg-white border rounded"
            >
              <div class="col-md-3 mt-1">
                <img
                  class="img-fluid img-responsive rounded product-image"
                  src="/course.png"
                />
              </div>
              <div class="col-md-6 mt-1">
                <h5>{{ kursus.name }}</h5>
                <div class="d-flex flex-row">
                  <div class="ratings mr-2">
                    <i class="fa fa-star"></i><i class="fa fa-star"></i
                    ><i class="fa fa-star"></i><i class="fa fa-star"></i>
                  </div>

                  <i>Oleh : {{ kursus.instructor }}</i
                  ><br />
                </div>
                <div class="mt-1 mb-1 spec-1">
                  <span></span>
                </div>

                <p class="text-justify text-truncate para mb-0">
                  {{ kursus.description }}<br /><br />
                </p>
              </div>
              <div
                class="align-items-center align-content-center col-md-3 border-left mt-1"
              >
                <div class="d-flex flex-row align-items-center">
                  <h4 class="mr-1">{{ formatRupiah(kursus.price) }}</h4>
                </div>
                <h6 class="text-success">Dimulai {{ kursus.date }}</h6>
                <div class="d-flex flex-column mt-4">
                  <button
                    v-if="kursus.status === 'published'"
                    class="btn btn-warning btn-sm"
                    type="button"
                  >
                    Published
                  </button>
                  <button
                    v-if="kursus.status === 'unpublished'"
                    class="btn btn-danger btn-sm"
                    type="button"
                  >
                    Unpublished
                  </button>
                  <button
                    @click="kelolaKursus(kursus.id)"
                    class="btn btn-outline-primary btn-sm mt-2"
                    type="button"
                  >
                    Kelola
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
import {
  list_kursus,
  show_kursus,
  create_kursus,
  update_kursus,
  delete_kursus,
} from "@/api/index";
import { toast } from "vue3-toastify";

export default {
  data() {
    return {
      list_kursus: [],
    };
  },
  created() {
    this.getKursus();
  },
  methods: {
    getKursus() {
      list_kursus()
        .then((response) => {
          this.list_kursus = response.data;
          console.log(response.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    kelolaKursus(id) {
      this.$router.push({ name: "kelola_kursus_id", params: { id: id } });
    },
    //formatRupiah
    formatRupiah(angka) {
      let number_string = angka.toString(),
        sisa = number_string.length % 3,
        rupiah = number_string.substr(0, sisa),
        ribuan = number_string.substr(sisa).match(/\d{3}/g);

      if (ribuan) {
        let separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
      }

      return "Rp " + rupiah + ",00";
    },
  },
};
</script>
