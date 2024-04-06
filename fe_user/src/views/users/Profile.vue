<template>
  <div class="card">
    <!-- Isi dengan konten tampilan profil pengguna -->
    <h4>My Profile</h4>
  </div>
  <div class="card">
    <div class="row">
      <div class="col-md-3 border-right">
        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
          <img
            class="rounded-circle mt-5"
            width="150px"
            src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"
          /><span class="font-weight-bold">{{ user_info.name }}</span
          ><span class="text-black-50">{{ user_info.email }}</span
          ><span> </span>
        </div>
      </div>
      <div class="col-md-5 border-right">
        <div class="p-3 py-5">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Profile Settings</h4>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
              <label class="labels">Name</label
              ><input
                type="text"
                class="form-control"
                v-model="user_info.name"
              />
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <label class="labels">Email</label
              ><input
                type="email"
                class="form-control"
                placeholder="enter phone number"
                v-model="user_info.email"
              />
            </div>
          </div>

          <div class="mt-5 text-center">
            <button
              @click="save_profile"
              class="btn btn-warning profile-button"
              type="button"
            >
              Save Profile
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-3 py-5">
          <div
            class="d-flex justify-content-between align-items-center experience"
          >
            <span>New Password</span
            ><span class="border px-3 p-1 add-experience"
              ><i class="fa fa-plus"></i>&nbsp;Password</span
            >
          </div>
          <br />
          <!--password lama, password baru, konfirmasi password baru-->
          <div class="row mt-2">
            <div class="col-md-12">
              <label class="labels">Old Password</label
              ><input
                type="password"
                class="form-control"
                placeholder="enter old password"
              />
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
              <label class="labels">New Password</label
              ><input
                type="password"
                class="form-control"
                placeholder="enter new password"
              />
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
              <label class="labels">Confirm Password</label
              ><input
                type="password"
                class="form-control"
                placeholder="confirm new password"
              />
            </div>
          </div>
          <div class="mt-5 text-center">
            <button
              @click="save_password"
              class="btn btn-warning profile-button"
              type="button"
            >
              Save Password
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
//import userInfo dari api index, ada variabel user_info, mmethod dan mounted
import { userInfo, saveUser, savePassword } from "@/api/index";
//import toastify dari vue-toastify
import { toast } from "vue3-toastify";
//export css toastify
import "vue3-toastify/dist/index.css";

export default {
  data() {
    return {
      user_info: [],
    };
  },
  methods: {
    //method untuk mengambil data user
    getUserInfo() {
      userInfo()
        .then((response) => {
          this.user_info = response;
          console.log(this.user_info);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    //method untuk menyimpan data user
    save_profile() {
      saveUser(this.user_info)
        .then((response) => {
          toast("Profile berhasil disimpan!", {
            theme: "colored",
            type: "warning",
            autoClose: 1000,
            dangerouslyHTMLString: true,
          });
        })
        .catch((error) => {
          console.log(error);
          toast("Profile gagal disimpan!", {
            theme: "colored",
            type: "warning",
            autoClose: 1000,
            dangerouslyHTMLString: true,
          });
        });
    },
    //method untuk menyimpan password
    save_password() {
      savePassword(this.user_info)
        .then((response) => {
          toast("Password berhasil disimpan!", {
            theme: "colored",
            type: "warning",
            autoClose: 1000,
            dangerouslyHTMLString: true,
          });
        })
        .catch((error) => {
          console.log(error);
          toast("Password gagal disimpan!", {
            theme: "colored",
            type: "warning",
            autoClose: 1000,
            dangerouslyHTMLString: true,
          });
        });
    },
  },
  mounted() {
    this.getUserInfo();
  },
};
</script>
