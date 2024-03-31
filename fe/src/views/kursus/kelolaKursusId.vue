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
            <Button icon="pi pi-pencil" @click="edit_bab(item.id)"  class="p-button-rounded p-button-success mr-2 ml-5" />
            <Button icon="pi pi-trash" @click="delete_bab(item.id)" class="p-button-rounded p-button-danger" />
            </li>

        </ul>
            </div>
    </div>
    <div class="col-12 md:col-8">
      <div class="card">
        <h5>Panel</h5>
        <Panel header="Header" :toggleable="true">
          <p class="line-height-3 m-0">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est laborum.
          </p>
        </Panel>
      </div>
      <div class="card">
        <h5>Fieldset</h5>
        <Fieldset legend="Legend" :toggleable="true">
          <p class="line-height-3 m-0">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est laborum.
          </p>
        </Fieldset>
      </div>

      <Card>
        <template v-slot:title>
          <div class="flex align-items-center justify-content-between mb-0">
            <h5>Card</h5>
            <Button icon="pi pi-plus" class="p-button-text" @click="toggle" />
          </div>
          <Menu
            id="config_menu"
            ref="menuRef"
            :model="cardMenu"
            :popup="true"
          />
        </template>

        <template v-slot:content>
          <p class="line-height-3 m-0">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est laborum.
          </p>
        </template>
      </Card>
    </div>

    <div class="col-12">
      <div class="card">
        <h5>Divider</h5>
        <div class="grid">
          <div class="col-5 flex align-items-center justify-content-center">
            <div class="p-fluid">
              <div class="field">
                <label for="username">Username</label>
                <InputText id="username" type="text" />
              </div>
              <div class="field">
                <label for="password">Password</label>
                <InputText id="password" type="password" />
              </div>
              <Button label="Login" class="mt-2"></Button>
            </div>
          </div>

          <div class="col-2">
            <Divider layout="vertical">
              <b>OR</b>
            </Divider>
          </div>
          <div class="col-5 align-items-center justify-content-center">
            <p class="line-height-3 m-0">
              Sed ut perspiciatis unde omnis iste natus error sit voluptatem
              accusantium doloremque laudantium, totam rem aperiam, eaque ipsa
              quae ab illo inventore veritatis et quasi architecto beatae vitae
              dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit
              aspernatur aut odit aut fugit, sed quia consequuntur magni dolores
              eos qui ratione voluptatem sequi nesciunt. Consectetur, adipisci
              velit, sed quia non numquam eius modi.
            </p>

            <Divider layout="horizontal" align="center">
              <span class="p-tag">Badge</span>
            </Divider>

            <p class="line-height-3 m-0">
              At vero eos et accusamus et iusto odio dignissimos ducimus qui
              blanditiis praesentium voluptatum deleniti atque corrupti quos
              dolores et quas molestias excepturi sint occaecati cupiditate non
              provident, similique sunt in culpa qui officia deserunt mollitia
              animi, id est laborum et dolorum fuga. Et harum quidem rerum
              facilis est et expedita distinctio. Nam libero tempore, cum soluta
              nobis est eligendi optio cumque nihil impedit quo minus.
            </p>

            <Divider align="right">
              <Button
                label="Button"
                icon="pi pi-search"
                class="p-button-outlined"
              ></Button>
            </Divider>

            <p class="line-height-3 m-0">
              Temporibus autem quibusdam et aut officiis debitis aut rerum
              necessitatibus saepe eveniet ut et voluptates repudiandae sint et
              molestiae non recusandae. Itaque earum rerum hic tenetur a
              sapiente delectus, ut aut reiciendis voluptatibus maiores alias
              consequatur aut perferendis doloribus asperiores repellat. Donec
              vel volutpat ipsum. Integer nunc magna, posuere ut tincidunt eget,
              egestas vitae sapien. Morbi dapibus luctus odio.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <h5>Splitter</h5>

        <Splitter style="height: 300px" class="mb-5">
          <SplitterPanel :size="30" :minSize="10">
            <div
              className="h-full flex align-items-center justify-content-center"
            >
              Panel 1
            </div>
          </SplitterPanel>
          <SplitterPanel :size="70">
            <Splitter layout="vertical">
              <SplitterPanel :size="15">
                <div
                  className="h-full flex align-items-center justify-content-center"
                >
                  Panel 2
                </div>
              </SplitterPanel>
              <SplitterPanel :size="50">
                <div
                  className="h-full flex align-items-center justify-content-center"
                >
                  Panel 3
                </div>
              </SplitterPanel>
            </Splitter>
          </SplitterPanel>
        </Splitter>
      </div>
    </div>
  </div>
</template>

<script>
import { show_kursus, create_bab, list_bab, show_bab, update_bab, delete_bab } from "@/api/index";
export default {
  data() {
    return {
        edit_bab_overlay: false,
      // Declare any data properties you need here
      data_course: {},
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
  },
};
</script>
