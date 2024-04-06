<template>
  <div class="card">
    <h4>Detail Tagihan</h4>
  </div>
  <div class="card">
    <!--tabel untuk invoice, price, course, name-->
    <table class="table">
      <thead>
        <tr></tr>
      </thead>
      <tbody>
        <tr>
          <td>Invoice</td>
          <td>{{ invoice_data.invoice }}</td>
        </tr>
        <tr>
          <td>Status</td>
          <td>{{ invoice_data.status }}</td>
        </tr>
        <tr>
          <td>Course Name</td>
          <td>{{ invoice_data.course_name }}</td>
        </tr>
        <tr>
          <td>User Registered</td>
          <td>{{ invoice_data.user_name }}</td>
        </tr>
        <tr>
          <td>Price</td>
          <td>{{ invoice_data.price }}</td>
        </tr>
      </tbody>
    </table>
    <h6>
      Cara pembayaran ditampilkan setelah anda mengklik tombol di bawah serta
      memilih bank / metode pembayaran
    </h6>
    <div class="d-grid gap-2">
      <a
        :href="invoice_data.payment_url"
        target="_blank"
        class="btn btn-success"
        type="button"
      >
        <span class="pi pi-dollar"></span>
        Pay</a
      >
    </div>
  </div>
</template>

<script>
import { showInvoice } from "@/api/index";
export default {
  name: "TagihanDetail",
  data() {
    return {
      // Data komponen di sini
      invoice_data: {},
    };
  },
  methods: {
    // Method di sini
    getInvoiceDetail() {
      showInvoice(this.$route.params.invoice)
        .then((response) => {
          this.invoice_data = response.invoice;
          console.log(this.invoice_data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
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
    this.getInvoiceDetail();
  },
};
</script>
