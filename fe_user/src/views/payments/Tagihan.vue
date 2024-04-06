<template>
  <div class="card">
    <h4>List Tagihan</h4>
  </div>
  <div class="card">
    <!--buatkan tabel tagihan-->

    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Course Name</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(tagihan, index) in list_tagihan.tagihan" :key="tagihan.id">
          <td>{{ index + 1 }}</td>
          <td>{{ tagihan.course_name }}</td>
          <td>{{ tagihan.status }}</td>
          <td>
            <!--view dengan icon mata-->
            <button
              @click="see(tagihan.invoice)"
              class="btn btn-success btn-sm"
              type="button"
              style="margin-right: 10px"
            >
              <span class="pi pi-eye"></span> View
            </button>
            <a
              v-if="tagihan.status === 'PENDING'"
              class="btn btn-primary btn-sm"
              :href="tagihan.payment_url"
              target="_blank"
            >
              Pay
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { listTagihan } from "@/api/index";
export default {
  data() {
    return {
      list_tagihan: [],
    };
  },
  methods: {
    getTagihan() {
      listTagihan()
        .then((response) => {
          this.list_tagihan = response;
          console.log(this.list_tagihan);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    see(invoice) {
      this.$router.push({
        name: "tagihan_detail",
        params: { invoice: invoice },
      });
    },
  },
  mounted() {
    this.getTagihan();
  },
};
</script>
