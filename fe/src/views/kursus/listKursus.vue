<template>
    <div class="grid p-fluid">
        <div class="col-12">
            <div class="card card-w-title">
                <h5>List Kursus</h5>
                <Toolbar>
                    <template v-slot:start>
                        <Button label="New" icon="pi pi-plus" class="mr-2" @click="kursus_baru_overlay" />
                        <Button label="Open" icon="pi pi-folder-open" class="p-button-secondary mr-2" />
                        <i class="pi pi-bars p-toolbar-separator mr-2"></i>
                    </template>

                </Toolbar>
            </div>
        </div>
    </div>
    <div class="grid p-fluid">
    <div class="col-12">
            <div class="card">
                <Dialog header="Kursus Baru" v-model:visible="kursus_baru" :breakpoints="{ '960px': '75vw' }" :style="{ width: '70vw' }" :modal="true">
                    <p class="line-height-3 m-0">
                        <input v-model="input_baru.name" type="text" class="p-inputtext p-component w-full" placeholder="Nama Kursus" />
                        <br>
                        <br>
                        <textarea v-model="input_baru.description" class="p-inputtext p-component w-full" placeholder="Deskripsi" rows="5"></textarea>
                        <!--Start date-->
                        <input type="date" v-model="input_baru.date" class="p-inputtext p-component w-full" placeholder="Start Date" />
                        <br><br>
                        <p>Level : {{ sliderValue }}</p>
                        <Slider v-model="sliderValue" /><br>
                        <input v-model="input_baru.price" type="number" class="p-inputtext p-component w-full" placeholder="Price" />
                        <br><br>
                        Course Image:
                        <FileUpload mode="basic" aria-placeholder="Pilih Gambar"cept="image/*" maxFileSize="1000000" @upload="onUpload" />   
                    </p>
                    <template #footer>
                        <Button label="Ok" @click="save" icon="pi pi-check" class="p-button-outlined" />
                    </template>
                </Dialog>
                <Dialog header="View Course" v-model:visible="liat_kursus_overlay" :breakpoints="{ '960px': '75vw' }" :style="{ width: '50vw' }" :modal="true">
                    <p class="line-height-3 m-0">
                        <center><h1>{{ liat_kursus_item.name }}</h1></center>
                        <p>{{ liat_kursus_item.description }}</p>
                        <table class="table">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Status</td>
                                    <td>{{ liat_kursus_item.status }}</td>
                                </tr>
                                <tr>
                                    <td>Pengajar</td>
                                    <td>{{ liat_kursus_item.instructor }}</td>
                                </tr> 
                                <tr>
                                    <td>Level</td>
                                    <td>{{ liat_kursus_item.level }}</td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td>{{ formatRupiah(liat_kursus_item.price) }}</td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>{{ liat_kursus_item.date }}</td>
                                </tr>
                                
                            </tbody>
                            </table>
                    </p>
                    <template #footer>
                        <Button label="Ok" @click="close" icon="pi pi-check" class="p-button-outlined" />
                    </template>
                </Dialog>
               <Dialog header="Edit Course" v-model:visible="edit_kursus_overlay" :breakpoints="{ '960px': '75vw' }" :style="{ width: '50vw' }" :modal="true">
                    <p class="line-height-3 m-0">
                        <center><h1><input type="text" v-model="liat_kursus_item.name "></h1></center>
                        <p><textarea v-model="liat_kursus_item.description" class="p-inputtext p-component w-full" placeholder="Deskripsi" rows="5"></textarea></p>
                        <table class="table">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        <!-- buatkan select option dengan value unpublished published dan completed -->
                                        <select class="form-control" v-model="liat_kursus_item.status">
                                            <option value="unpublished">Unpublished</option>
                                            <option value="published">Published</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Level</td>
                                    <td>
                                        <p>Level : {{ liat_kursus_item.level }}</p>
                                        <Slider v-model="liat_kursus_item.level" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td>
                                        <input v-model="liat_kursus_item.price" type="number" class="p-inputtext p-component w-full" placeholder="Price" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>
                                        <input type="date" v-model="liat_kursus_item.date" class="p-inputtext p-component w-full" placeholder="Start Date" />
                                    </td>
                                </tr>
                                
                            </tbody>
                            </table>
                    </p>
                    <template #footer>
                        <Button label="Ok" @click="simpan_edit(liat_kursus_item.id)" icon="pi pi-check" class="p-button-outlined" />
                    </template>
                </Dialog>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kursus</th>
                            <th>Deskripsi</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(kursus, index) in list_kursus.data" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>{{ kursus.name }}</td>
                            <td>{{ kursus.description }}</td>
                            <td>
                                <Button icon="pi pi-eye" @click="lihat_kursus(kursus.id)" class="p-button-rounded p-button-info mr-2" />
                                <Button icon="pi pi-pencil" @click="edit_kursus(kursus.id)"  class="p-button-rounded p-button-success mr-2" />
                                <Button icon="pi pi-trash" @click="hapus_kursus(kursus.id)" class="p-button-rounded p-button-danger" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
    </div>
</template>

<script>
import { list_kursus, show_kursus, create_kursus, update_kursus, delete_kursus } from '@/api/index';
import { toast } from 'vue3-toastify';

export default {
    data() {
        return {
            list_kursus: [],
            kursus_baru: false,
            liat_kursus_item: {},
            liat_kursus_overlay: false,
            edit_kursus_overlay: false,
            sliderValue: 20,
            input_baru : {}
        }
    },
    created() {
        this.getKursus();
    },
    methods: {
        getKursus() {
            list_kursus().then(response => {
                this.list_kursus = response.data;
                console.log(response.data.data);
            }).catch(error => {
                console.log(error);
            });
        },
        kursus_baru_overlay() {
            this.kursus_baru = true;
        },
        lihat_kursus(id) {
            show_kursus(id).then(response => {
                console.log(response.data);
                this.liat_kursus_item = response.data;
                this.liat_kursus_overlay = true;
            }).catch(error => {
                console.log(error);
            });
        },
        save(){
            this.input_baru.level = this.sliderValue;
            this.input_baru.category = 1;
            console.log(this.input_baru)
            create_kursus(this.input_baru).then(response => {
                console.log(response.data);
                this.getKursus();
                this.kursus_baru = false;
                alert("Kursus Berhasil Ditambahkan");ß
            }).catch(error => {
                console.log(error);
            });
        },
        edit_kursus(id){
            show_kursus(id).then(response => {
                console.log(response.data);
                this.liat_kursus_item = response.data;
                this.edit_kursus_overlay = true;
            }).catch(error => {
                console.log(error);
            });
        },
        simpan_edit(id){
            console.log(this.liat_kursus_item)
            update_kursus(id, this.liat_kursus_item).then(response => {
                console.log(response.data);
                this.getKursus();
                alert("Kursus Berhasil Diupdate");
                this.edit_kursus_overlay = false;
            }).catch(error => {
                console.log(error);
            });

        },
        hapus_kursus(id){
            //alert konfirmasi dulu
            if(confirm("Apakah Anda Yakin Ingin Menghapus Kursus Ini?")){
                delete_kursus(id).then(response => {
                    console.log(response.data);
                    this.getKursus();
                    alert("Kursus Berhasil Dihapus");
                }).catch(error => {
                    console.log(error);
                });
            }
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
    }
}
</script>