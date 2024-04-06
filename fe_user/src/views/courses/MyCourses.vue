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
              v-for="(kursus, index) in my_courses"
              :key="index"
              class="row p-2 bg-white border rounded"
            >
              <div class="col-md-3 mt-1">
                <img
                  class="img-fluid img-responsive rounded product-image"
                  src="http://localhost:5173/course.png"
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
                  <h4 class="mr-1"></h4>
                </div>
                <h6 class="text-success">Dimulai {{ kursus.date }}</h6>
                <div class="d-flex flex-column mt-4">
                  <button
                    v-if="kursus.status === 'published'"
                    class="btn btn-success btn-sm"
                    type="button"
                    @click="learn_now(kursus.id)"
                  >
                    Learn Now
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
                    class="btn btn-outline-danger btn-sm mt-2"
                    type="button"
                  >
                    Unenroll
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
import { myCourses } from "@/api/index";
export default {
  name: "MyCourses",
  data() {
    return {
      // Data komponen di sini
      my_courses: [],
    };
  },
  methods: {
    getMyCourses() {
      myCourses()
        .then((response) => {
          this.my_courses = response.data;
          console.log(this.my_courses);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    learn_now(id) {
      //simpan id ke local storage dengan nama "selected_course"
      localStorage.setItem("selected_course", id);
      this.$router.push({ name: "LearnNow", params: { id: id } });
    },
  },
  mounted() {
    this.getMyCourses();
  },
};
</script>
