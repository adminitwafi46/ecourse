<template>
  <div class="card">
    <!-- Tambahkan elemen HTML di sini -->
    <h4>{{ course_data.name }}</h4>
  </div>
  <div class="card">
    <div class="row">
      <div class="col-md-3 mt-1">
        <img
          class="img-fluid img-responsive rounded product-image"
          src="http://localhost:5173/course.png"
        />
      </div>
      <div class="col-md-9 mt-1">
        <!--buatkan tabel untuk instruktur, price, level dan start date-->
        <table class="table">
          <tbody>
            <tr>
              <td>Instruktur</td>
              <td>{{ course_data.instructor }}</td>
            </tr>
            <tr>
              <td>Price</td>
              <td>{{ formatRupiah(course_data.price) }}</td>
            </tr>
            <tr>
              <td>Level</td>
              <td>{{ course_data.level }}</td>
            </tr>
            <tr>
              <td>Start Date</td>
              <td>{{ course_data.date }}</td>
            </tr>
          </tbody>
        </table>
        <!--tambahkan deskripsi kursus-->
        <h5>Course Description:</h5>
        <p class="text-justify para mb-0">
          {{ course_data.description }}
        </p>
        <h5>Syllabus</h5>
        <ul>
          <li v-for="bab in course_bab" :key="bab.id">
            <b>{{ bab.name }}</b>
            <p style="margin-bottom: 10px">{{ bab.description }}</p>
          </li>
        </ul>
        <div class="d-grid gap-2">
          <button
            @click="see(course_data.id)"
            class="btn btn-success"
            type="button"
          >
            <!--icon mata-->
            <i class="pi pi-eye"></i>
            Enroll Now
          </button>
        </div>
      </div>
    </div>
  </div>
  <!--bagian overlay-->
  <Dialog
    header="Enroll Confirmation"
    v-model:visible="enroll_confirmation_overlay"
    :breakpoints="{ '960px': '75vw' }"
    :style="{ width: '50vw' }"
    :modal="true"
  >
    <p class="line-height-3 m-0">
      Are you sure you want to enroll in this course?
      <!--buatkan tabel nama pengguna, course, price, level, payment fee (5000)-->
        <table class="table">
            <tbody>
            <tr>
                <td>User</td>
                <td>{{ user_data.name }}</td>
            </tr>
            <tr>
                <td>Course</td>
                <td>{{ course_data.name }}</td>
            </tr>
            <tr>
                <td>Price</td>
                <td>{{ formatRupiah(course_data.price) }}</td>
            </tr>
            <tr>
                <td>Level</td>
                <td>{{ course_data.level }}</td>
            </tr>
            <tr>
                <td>Payment Fee</td>
                <td>{{ formatRupiah(5000) }}</td>
            </tr>
            </tbody>
        </table>

        <!--jumlah yang harus anda bayar adalah-->
        <h6>
        Jumlah yang harus anda bayar adalah {{ formatRupiah(course_data.price + 5000) }} yang akan masuk ke tagihan anda. Anda dapat mengakses kursus ini setelah pembayaran selesai.
            </h6>
    </p>
    <template #footer>
      <Button
        label="Ok"
        @click="enroll"
        icon="pi pi-check"
        class="p-button"
      />
    </template>
  </Dialog>
</template>

<script>
import { showCourse, userInfo, storePayment } from "@/api/index";
//toastify
import { toast } from "vue3-toastify";
//css toastify
import "vue3-toastify/dist/index.css";
export default {
  data() {
    return {
      // Tambahkan data di sini
      course_data: {},
      course_bab: [],
      user_data: {},
      payment_info: {
        'course_id': null,
        'user_id': null,
        'amount': null
      },
      enroll_confirmation_overlay: false,
    };
  },
  methods: {
    // Tambahkan method di sini
    getCourseDetail() {
      showCourse(this.$route.params.id)
        .then((response) => {
          this.course_data = response.data;
          this.course_bab = response.babs;
          console.log(this.course_bab);
          console.log(this.course_data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    //format rupiah
    formatRupiah(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    see(id) {
      this.getCourseDetail();
      //user info
      userInfo()
        .then((response) => {
          this.user_data = response;
          console.log(this.user_data);
        })
        .catch((error) => {
          console.log(error);
        });
      this.enroll_confirmation_overlay = true;
    },
    enroll() {
      this.payment_info.course_id = this.course_data.id;
      this.payment_info.user_id = this.user_data.id;
        this.payment_info.amount = this.course_data.price + 5000;
      storePayment(this.payment_info)
        .then((response) => {
          console.log(response);
            toast("Payment Success!", {
                theme: "colored",
                type: "success",
                autoClose: 1000,
                dangerouslyHTMLString: true,
            });
            //tunggu seribu(auto close) lalu push ke tagihan_detail dengan parameter dari response.payment.invoice
            this.$router.push({ name: "tagihan_detail", params: { invoice: response.payment.invoice } });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    // Tambahkan kode yang akan dijalankan setelah komponen dipasang di sini
    this.getCourseDetail();
  },
};
</script>

<style scoped>
/* Tambahkan gaya CSS di sini */
</style>
