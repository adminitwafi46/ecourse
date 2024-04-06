<template>
  <div class="grid">
    <div class="col-12">
      <div class="card">
        <h5>{{ data_course.name }}</h5>
        <Toolbar>
          <template v-slot:start>
            <Button
              @click="new_bab_overlay"
              label="New Bab"
              icon="pi pi-plus"
              class="mr-2"
            />
          </template>
          <template v-slot:end>
            <SplitButton
              :label="data_course.status"
              :model="toolbarItems"
            ></SplitButton>
          </template>
        </Toolbar>
      </div>
    </div>
    <Dialog header="Edit Materi" v-model:visible="edit_materi_overlay" :breakpoints="{ '960px': '75vw' }" :style="{ width: '50vw' }" :modal="true">
      <p class="line-height-3 m-0">
        <!--name-->
        <input type="text" v-model="edit_materi_data.name" placeholder="Masukkan nama materi" class="w-full p-3">         
        <!-- jika jenis === text maka gunakan ckeditor--><br><br>
        <ckeditor v-if="edit_materi_data.jenis === 'text'" :editor="editor" v-model="edit_materi_data.isi" :config="editorConfig" class="custom-editor"></ckeditor>
        <!-- jika jenis === youtube maka gunakan input text dan preview video menggunakan embed--><br><br>
        <input type="text" v-if="edit_materi_data.jenis === 'youtube'" v-model="edit_materi_data.isi" placeholder="Masukkan url youtube" class="w-full p-3">
        <iframe v-if="edit_materi_data.jenis === 'youtube'" :src="`https://www.youtube.com/embed/${edit_materi_data.isi}`" width="100%" height="500px" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        
        <!--descriptiom-->
        Deskripsi :
        <textarea v-model="edit_materi_data.description" placeholder="Masukkan deskripsi materi" class="w-full p-5"></textarea>
      </p>
                    <template #footer>
                        <Button label="Save" @click="simpan_edit_materi" icon="pi pi-check" class="p-button-outlined" />
                    </template>
    </Dialog>
    <Dialog
      header="Bab Baru"
      v-model:visible="new_bab"
      :breakpoints="{ '960px': '75vw' }"
      :style="{ width: '50vw' }"
      :modal="true"
    >
      <p class="line-height-3 m-0">
        <!-- Form Bab Baru -->
        <div class="p-fluid">
          <div class="field">
            <label for="name">Name</label>
            <InputText
              id="name"
              type="text"
              v-model="data_bab_baru.name"
            />
          </div>
          <div class="field">
            <label for="description">Description</label>
            <textarea class="w-full p-5"
              v-model="data_bab_baru.description" placeholder="Masukkan deskripsi bab baru"
            >
            </textarea>
          </div>
          <Button
            label="Save"
            @click="save_bab"
            icon="pi pi-check"
            class="p-button-outlined"
          />
        </div>
      </p>
      <template #footer>
        
      </template>
    </Dialog>
    <Dialog
      header="Materi Baru"
      v-model:visible="tambah_materi_overlay"
      :breakpoints="{ '960px': '75vw' }"
      :style="{ width: '50vw' }"
      :modal="true"
    >
      <p class="line-height-3 m-0">
        <!-- Form Materi Baru -->
       <!--name-->
        <input type="text" v-model="new_materi_data.name" placeholder="Masukkan nama materi" class="w-full p-3">
        <!-- jenis, dengan option select ada text, video, pdf -->
        <br><br>
            Jenis Materi : 
        <br>
        <select v-model="new_materi_data.jenis" class="w-full p-3" placeholder="Jenis Materi">
          <option value="text">Text</option>
          <option value="video">Video</option>
          <option value="pdf">PDF</option>
          <option value="youtube">Youtube</option>
          <!--kuis-->
          <option value="quiz">Quiz</option>
        </select>

        <br><br>
        <ckeditor v-if="new_materi_data.jenis === 'text'" :editor="editor" v-model="editorData" :config="editorConfig" class="custom-editor"></ckeditor>

        <div v-if="new_materi_data.jenis === 'video'"  >Masukkan file video :</div>
        <input type="file" v-if="new_materi_data.jenis === 'video'" class="w-full form-control p-3" @change="handleVideoUpload">
        <div v-if="new_materi_data.jenis === 'pdf'"  >Masukkan file pdf :</div>
        <input type="file" v-if="new_materi_data.jenis === 'pdf'" class="w-full form-control p-3" @change="handlePdfUpload">
        <div v-if="new_materi_data.jenis === 'youtube'"  >Masukkan url youtube:</div>
        <input type="text" v-if="new_materi_data.jenis === 'youtube'" class="w-full form-control p-3" v-model="new_materi_data.text">
        
        <!--text area untuk description-->
        <br>
        <textarea v-model="new_materi_data.description" placeholder="Masukkan deskripsi materi" class="w-full p-5"></textarea>
        <br>
        <!--button save dan memanggil fungsi save_materi-->
        <Button
          label="Save"
          @click="save_materi"
          icon="pi pi-check"
          class="p-button"
        />
    </p>
      <template #footer>
        
      </template>
    </Dialog>
    <Dialog
      header="Edit Bab"
      v-model:visible="edit_bab_overlay"
      :breakpoints="{ '960px': '75vw' }"
      :style="{ width: '50vw' }"
      :modal="true"
    >
      <p class="line-height-3 m-0">
        <!-- Form Bab Baru -->
        <div class="p-fluid">
          <div class="field">
            <label for="name">Name</label>
            <InputText
              id="name"
              type="text"
              v-model="data_perbab_id.name"
            />
          </div>
          <div class="field">
            <label for="description">Description</label>
            <textarea class="w-full p-5"
              v-model="data_perbab_id.description" placeholder="Masukkan deskripsi bab baru"
            >
            </textarea>
          </div>
          <Button
            label="Save"
            @click="save_edit_bab"
            icon="pi pi-check"
            class="p-button-outlined"
          />
        </div>
      </p>
      <template #footer>
        
      </template>
    </Dialog>
    <div class="col-12 md:col-4">
      <div class="card">
        <h5>List Bab</h5>
        <ul class="list-group">
            <li v-for="item, index in list_bab_id" class="list-group-item mr-15" key="index">{{item.name}}
            <Button icon="pi pi-eye" @click="liat_materi(item.id)" class="p-button-rounded p-button-info mr-2 ml-5" />
            <Button icon="pi pi-pencil" @click="edit_bab(item.id)"  class="p-button-rounded p-button-success mr-2" />
            <Button icon="pi pi-trash" @click="delete_bab(item.id)" class="p-button-rounded p-button-danger" />
            </li>

        </ul>
            </div>
    </div>
    <div class="col-12 md:col-8">
      <div class="card">
              <div class="card">
        <h5>Materi Bab : {{materi.data_bab.name}} </h5>
        <Toolbar>
          <template v-slot:start>
            <Button
              @click="materi_baru"
              label="Materi Baru"
              icon="pi pi-plus"
              class="mr-2"
            />
          </template>
        </Toolbar>
      </div>
        <div v-for="item, index in materi.list_materi" key="index">
<Panel :header="`${item.name} | ${item.jenis}`" :toggleable="true">
  <p v-if="item.jenis === 'text'" class="line-height-3 m-0">
    <div v-html="item.isi"></div>
  </p>
  <object v-else-if="item.jenis === 'pdf'" :data="`http://localhost:8000/materi_pdf/${item.isi}`" type="application/pdf" width="100%" height="500px">
    <p>Silahkan unduh konten jika ebook tidak muncul</p>
    <embed :src="`http://localhost:8000/materi_pdf/${item.isi}`" type="application/pdf" width="100%" height="500px" />
    <a :href="`http://localhost:8000/materi_pdf/${item.isi}`" download class="p-button pi pi-download text-white"> Download</a>
  </object>
  <div v-else-if="item.jenis === 'video'">
    <video :src="`http://localhost:8000/materi_video/${item.isi}`" controls width="100%" height="auto">
      Your browser does not support the video tag.
    </video>
    <a :href="`http://localhost:8000/materi_video/${item.isi}`" download class="p-button pi pi-download text-white"> Download Video</a>
  </div>
  <div v-else-if="item.jenis === 'youtube'">
    <iframe width="100%" height="500px" :src="`https://www.youtube.com/embed/${item.isi}`" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  </div>
  <div v-else-if="item.jenis === 'quiz'">
    <!--buat tombol untuk memanggil fungsi kelola_kuis(item.id)-->
    <Button label="Kelola Kuis" @click="kelola_kuis(item.id)" class="p-button-rounded p-button-info" />
  </div>
  
  <p class="line-height-3 m-0">
    <i>Deskripsi:</i><br>
    {{item.description}}
  </p><br>
  Pilihan:<br>
  <!--dua tombol dan iconnya yaitu edit dan hapus-->
  <Button icon="pi pi-pencil" @click="edit_materi(item.id)" class="p-button-rounded p-button-success mr-2" />
  <Button icon="pi pi-trash" @click="delete_materi_id(item.id)" class="p-button-rounded p-button-danger" />
</Panel>



        <br>
        </div>
                
      </div>
      

      
    </div>

    

    
  </div>
</template>

<script>
import { 
    show_kursus, 
    create_bab, 
    list_bab, show_bab, 
    update_bab, 
    delete_bab,
    create_materi,
    list_materi,  
    show_materi,
    update_materi,
    delete_materi
  } from "@/api/index";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
  data() {
    return {
        edit_bab_overlay: false,
        edit_materi_overlay: false,
        editor : ClassicEditor,
        editorData: '<br><br><br><br><br>',
        editorConfig: {
                    // The configuration of the editor.
                },
        tambah_materi_overlay: false,
      // Declare any data properties you need here
      data_course: {},
      new_materi_data : {},
      materi : {
        data_bab : {},
        list_materi : [],
      },
      list_bab_id : [],
      id: null,

      index_bab : null,
      new_bab: false,
      data_bab_baru: {
        name: "",
        description: "",
        course_id: null,
      },
    data_perbab_id : {},
    edit_materi_data : {},
    };
  },
  mounted() {
    // Fetch data from API using the id parameter
    const id = this.$route.params.id;
    this.id = id;
    console.log(id);
    show_kursus(id)
      .then((response) => {
        this.data_course = response.data;
        console.log(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
    list_bab(id)
      .then((response) => {
        this.list_bab_id = response.data;
        console.log(this.list_bab_id);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  methods: {
    handleVideoUpload(e) {
        console.log(e.target.files[0]);
        this.new_materi_data.video = e.target.files[0];
    },
    handlePdfUpload(e) {
        console.log(e.target.files[0]);
        this.new_materi_data.pdf = e.target.files[0];
    },
    new_bab_overlay() {
      this.new_bab = true;
    },
    save_bab() {
        this.data_bab_baru.course_id = this.id; 
        console.log(this.data_bab_baru);
        create_bab(this.data_bab_baru)
          .then((response) => {
            console.log(response.data);
            alert("Bab baru berhasil ditambahkan");
            this.new_bab = false;
            this.data_bab_baru = {
              name: "",
              description: "",
              course_id: null,
            };
            //get list bab
            list_bab(this.id)
              .then((response) => {
                this.list_bab_id = response.data;
                console.log(this.list_bab_id);
              })
            
          })
          .catch((error) => {
            console.log(error);
          });
        
    },
    edit_bab(id) {
      show_bab(id)
        .then((response) => {
            this.index_bab = id;
          this.data_perbab_id = response.data;
          console.log(this.data_perbab_id);
          this.edit_bab_overlay = true;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    save_edit_bab() {
        console.log(this.data_perbab_id);
        update_bab(this.data_perbab_id.id, this.data_perbab_id)
          .then((response) => {
            console.log(response.data);
            alert("Bab berhasil diupdate");
            this.edit_bab_overlay = false;
            //get list bab
            list_bab(this.id)
              .then((response) => {
                this.list_bab_id = response.data;
                console.log(this.list_bab_id);
              })
          })
          .catch((error) => {
            console.log(error);
          });
    },
    delete_bab(id) {
        //alert konfirmasi dulu
        if (confirm("Apakah anda yakin ingin menghapus bab ini?")) {
            delete_bab(id)
              .then((response) => {
                console.log(response.data);
                alert("Bab berhasil dihapus");
                //get list bab
                list_bab(this.id)
                  .then((response) => {
                    this.list_bab_id = response.data;
                    console.log(this.list_bab_id);
                  })
              })
              .catch((error) => {
                console.log(error);
              });
        }
    },
    liat_materi(id) {
        //ambil data bab dengan show bab per id lalu simpan ke this.materi.data_bab
        show_bab(id)
          .then((response) => {
            this.materi.data_bab = response.data;
            console.log(this.materi);
          })
          .catch((error) => {
            console.log(error);
          });
        //ambil list materi dengan list_materi per id lalu simpan ke this.materi.list_materi
        list_materi(id)
          .then((response) => {
            this.materi.list_materi = response.data;
            console.log(this.materi);
          })
          .catch((error) => {
            console.log(error);
          });
          console.log(this.materi);
    },
    materi_baru() {
        //if this.materi.data_bab.id is null, alert("Pilih bab terlebih dahulu")
        if (this.materi.data_bab.id == null) {
            alert("Pilih bab terlebih dahulu");
        } else {
            this.tambah_materi_overlay = true;
        }
    },
    edit_materi(id) {
        this.edit_materi_overlay = true;
        //ambil data materi dengan show_materi per id lalu simpan ke this.edit_materi_data
        show_materi(id)
          .then((response) => {
            this.edit_materi_data = response.data;
            console.log(this.edit_materi_data);
          })
          .catch((error) => {
            console.log(error);
          });
    },
    simpan_edit_materi() {
        console.log(this.edit_materi_data);
        //panggil API update_materi
        update_materi(this.edit_materi_data.id, this.edit_materi_data)
          .then((response) => {
            console.log(response);
            alert("Materi berhasil diupdate");
            this.edit_materi_overlay = false;
            //panggil liat_materi
            this.liat_materi(this.materi.data_bab.id);
          })
          .catch((error) => {
            console.log(error);
          });
    },
    delete_materi_id(id) {
        //alert konfirmasi dulu
        if (confirm("Apakah anda yakin ingin menghapus materi ini?")) {
            delete_materi(id)
              .then((response) => {
                console.log(response);
                alert("Materi berhasil dihapus");
                //panggil liat_materi
                this.liat_materi(this.materi.data_bab.id);
              })
              .catch((error) => {
                console.log(error);
              });
        }
    },
    //fungsi kelola kuis dengan mempush route dengan parameter id
    kelola_kuis(id) {
        this.$router.push({ name: 'kelola_kuis_id', params: { id: id } });
    },
    save_materi() {
        //save materi
        console.log(this.new_materi_data);
        //masukkan this.id ke this.new_materi_data.bab_id
        this.new_materi_data.bab_id = this.materi.data_bab.id;
        //jika jenis materi adalah text, maka isi materi adalah editorData
        if (this.new_materi_data.jenis === 'text') {
            this.new_materi_data.isi = this.editorData;
        }
        //jika jenis materi adalah quiz maka isi materi adalah null
        if (this.new_materi_data.jenis === 'quiz') {
            this.new_materi_data.isi = null;
        }
        
        //panggil API create_materi
        create_materi(this.new_materi_data)
          .then((response) => {
            console.log(response);
            alert("Materi berhasil ditambahkan");
            this.tambah_materi_overlay = false;
            this.new_materi_data = {};
            //panggil liat_materi
            this.liat_materi(this.materi.data_bab.id);
          })
          .catch((error) => {
            console.log(error);
          });
    },
  },
};
</script>
<style scoped>
.custom-editor {
  max-height: 10em; /* Atur tinggi maksimum menjadi 10 baris */
  overflow-y: auto; /* Tambahkan overflow untuk memastikan konten dapat diakses */
}
</style>