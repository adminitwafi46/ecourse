<template>
  <div class="grid">
    <div class="col-12">
      <div class="card">
        <h5>Mengelola Kuis : {{ desc_kuis.name }}</h5>
        <Toolbar>
          <template v-slot:start>
            <Button
              @click="soal_baru_click"
              label="Tambah Soal"
              icon="pi pi-plus"
              class="mr-2"
            />
          </template>
          <template v-slot:end> </template>
        </Toolbar>
      </div>
    </div>
  </div>
  <div class="card">
    <Panel header="Daftar Soal">
      <DataTable :value="list_soal" :paginator="true" :rows="5">
        <!--kolom no dengan sesuai urutan mulai dari 1-->
        <Column field="id" header="No" style="width: 5%"></Column>
        <Column field="question" header="Soal">
          <template #body="slotProps">
            <div v-html="slotProps.data.question"></div>
          </template>
        </Column>

        <Column field="action" header="Aksi">
          <template #body="slotProps">
            <!--button view eye-->
            <Button
              icon="pi pi-eye"
              class="p-button-success"
              @click="view_jawaban(slotProps.data.id)"
            />
            <Button
              icon="pi pi-pencil"
              class="p-button-warning"
              @click="edit_soal(slotProps.data.id)"
            />
            <Button
              icon="pi pi-trash"
              class="p-button-danger"
              @click="hapus_soal(slotProps.data.id)"
            />
          </template>
        </Column>
      </DataTable>
    </Panel>
  </div>
  <!--Bagian khusus dialog-->
  <Dialog
    header="Soal Baru"
    v-model:visible="soal_baru_overlay"
    :breakpoints="{ '960px': '75vw' }"
    :style="{ width: '50vw' }"
    :modal="true"
  >
    <p class="line-height-3 m-0">
      <!--masukkan soal-->
      Masukkan soal di bawah :
      <ckeditor
        v-model="editorData"
        :editor="editor"
        :config="editorConfig"
      ></ckeditor>
    </p>
    <template #footer>
      <Button
        label="Simpan"
        @click="simpan_soal_baru"
        icon="pi pi-check"
        class="p-button-warning"
      />
    </template>
  </Dialog>
  <Dialog
    header="Edit Baru"
    v-model:visible="edit_soal_overlay"
    :breakpoints="{ '960px': '75vw' }"
    :style="{ width: '50vw' }"
    :modal="true"
  >
    <p class="line-height-3 m-0">
      <!--masukkan soal-->
      Masukkan soal di bawah :
      <ckeditor
        v-model="editorData"
        :editor="editor"
        :config="editorConfig"
      ></ckeditor>
    </p>
    <template #footer>
      <Button
        label="Simpan"
        @click="simpan_edit_soal"
        icon="pi pi-check"
        class="p-button-warning"
      />
    </template>
  </Dialog>
  <Dialog
    header="List Jawaban"
    v-model:visible="show_jawaban_overlay"
    :breakpoints="{ '960px': '75vw' }"
    :style="{ width: '50vw' }"
    :modal="true"
  >
    <p class="line-height-3 m-0">
        <!--tombol tambah jawaban-->
        <Button
            label=""
            @click="tambah_jawaban_form = true"
            icon="pi pi-plus"
            class="mr-2"
        /><br><br>
        <table class="table table-striped">
            <tr>
                <th>No</th>
                <th>Jawaban</th>
                <th>Benar / Salah</th>
                <th>Aksi</th>

            </tr>
            <tr v-for="(jawaban, index) in list_jawaban" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ jawaban.answer }}</td>
                <td>
                    <span v-if="jawaban.salah_benar == 1">Benar</span>
                    <span v-else>Salah</span>
                </td>
                <td>

                    <Button
                        label="Hapus"
                        @click="hapus_jawaban_confirm(jawaban.id)"
                        icon="pi pi-trash"
                        class="btn btn-sm"
                    />
                    <!--jadikan jawaban benar-->
                    <Button
                        label="Jadikan Benar"
                        @click="set_jawaban_benar(jawaban.id)"
                        icon="pi pi-check"
                        class="btn btn-sm"
                    />
                </td>

            </tr>
            <tr v-if="tambah_jawaban_form">
                <td></td>
                <td>
                    <InputText v-model="jawaban_baru_data.answer" placeholder="Masukkan jawaban baru" /> | 
                    <Button
                        label="Simpan"
                        @click="simpan_jawaban_baru"
                        icon="pi pi-check"
                        class="btn btn-sm btn-warning"
                    />
                </td>
            </tr>
        </table>
    </p>
    <template #footer> </template>
  </Dialog>
</template>

<script>
import {
  show_materi,
  create_kuis,
  show_list_kuis,
  show_list_jawaban_kuis,
  create_jawaban,
  update_jawaban_benar,
    delete_jawaban,
    show_kuis_id,
    update_kuis_id,
    delete_kuis_id
} from "@/api/index";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  data() {
    return {
      id_kuis: null, // Variabel id_kuis akan diisi dari parameter id di route
      kuis_terpilih : null,
      desc_kuis: {},
      tambah_jawaban_form : false,
      soal_baru_overlay: false,
      show_jawaban_overlay: false,
        edit_soal_overlay: false,
      soal_baru_data: {
        materi_id: null,
        question: "",
      },
      jawaban_baru_data: {
        kuis_id: null,
        answer: "",
      },
      list_soal: [],
      editor: ClassicEditor,
      editorData: "",
      editorConfig: {
        // The configuration of the editor.
      },
        list_jawaban: [],
        kuis_id_terpilih: null,
    };
  },
  methods: {
    // Tambahkan method sesuai kebutuhan Anda
    soal_baru_click() {
      this.soal_baru_overlay = true;
    },
    simpan_soal_baru() {
      // Simpan soal baru
      this.soal_baru_data.materi_id = this.id_kuis;
      this.soal_baru_data.question = this.editorData;
      create_kuis(this.soal_baru_data).then((res) => {
        alert("Soal berhasil disimpan");
        this.soal_baru_overlay = false;
        this.editorData = "";
        show_list_kuis(this.id_kuis).then((res) => {
          this.list_soal = res.data;
        });
      });
    },
    edit_soal(id) {
      // Edit soal
      this.kuis_id_terpilih = id;
      console.log(id);
      this.edit_soal_overlay = true;
        show_kuis_id(id).then((res) => {
            this.editorData = res.data.question;
        });
    },
    view_jawaban(id) {
        console.log(id);
        this.kuis_terpilih = id;
      this.show_jawaban_overlay = true;
      // Tampilkan jawaban
      show_list_jawaban_kuis(id).then((res) => {
        this.list_jawaban = res.data;
      });
    },
    simpan_jawaban_baru() {
      // Simpan jawaban baru
      this.jawaban_baru_data.kuis_id = this.kuis_terpilih;
      create_jawaban(this.jawaban_baru_data).then((res) => {
        alert("Jawaban berhasil disimpan");
        this.tambah_jawaban_form = false;
        this.jawaban_baru_data.answer = "";
        show_list_jawaban_kuis(this.kuis_terpilih).then((res) => {
          this.list_jawaban = res.data;

        });
      });
    },
    set_jawaban_benar(id) {
      // Jadikan jawaban benar
      update_jawaban_benar(id).then((res) => {
        alert("Jawaban berhasil dijadikan benar");
        show_list_jawaban_kuis(this.kuis_terpilih).then((res) => {
          this.list_jawaban = res.data;
        });
      });
    },
    hapus_jawaban_confirm(id) {
      // Hapus jawaban
      if (confirm("Apakah Anda yakin ingin menghapus jawaban ini?")) {
        delete_jawaban(id).then((res) => {
          alert("Jawaban berhasil dihapus");
          show_list_jawaban_kuis(this.kuis_terpilih).then((res) => {
            this.list_jawaban = res.data;
          });
        });
      }
    },
    simpan_edit_soal() {
      // Simpan soal baru
      this.soal_baru_data.materi_id = this.kuis_id
      this.soal_baru_data.question = this.editorData;
      update_kuis_id(this.kuis_id_terpilih, this.soal_baru_data).then((res) => {
        alert("Soal berhasil disimpan");
        this.edit_soal_overlay = false;
        this.editorData = "";
        show_list_kuis(this.id_kuis).then((res) => {
          this.list_soal = res.data;
        });
      });
    },
    hapus_soal(id) {
      // Hapus soal
      if (confirm("Apakah Anda yakin ingin menghapus soal ini?")) {
        delete_kuis_id(id).then((res) => {
          alert("Soal berhasil dihapus");
          show_list_kuis(this.id_kuis).then((res) => {
            this.list_soal = res.data;
          });
        });
      }
    },
  },
  mounted() {
    //id kuis diambil dari parameter id pada route
    this.id_kuis = this.$route.params.id;
    show_materi(this.id_kuis).then((res) => {
      this.desc_kuis = res.data;
    });
    show_list_kuis(this.id_kuis).then((res) => {
      this.list_soal = res.data;
    });
  },
};
</script>
