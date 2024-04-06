<script setup>
import { useLayout } from "@/layout/composables/layout";
import { ref, computed } from "vue";
import { register } from "@/api/index";
import AppConfig from "@/layout/AppConfig.vue";

//router
import { useRouter } from "vue-router";
const $router = useRouter();

//toast
import { toast } from "vue3-toastify";

const { layoutConfig } = useLayout();
const name = ref("");
const email = ref("");
const password = ref("");
const checked = ref(false);
//pemberitahuan false
const notify = ref(false);

//register_proses
const register_proses = () => {
  register({
    name: name.value,
    email: email.value,
    password: password.value,
  })
    .then((response) => {
      console.log(response);
      //kosongkan form
      name.value = "";
      email.value = "";
      password.value = "";
      notify.value = true;
    })
    .catch((error) => {
      console.log(error);
    });
};

const logoUrl = computed(() => {
  return `/layout/images/${layoutConfig.darkTheme.value ? "logo" : "logo"}.png`;
});
</script>

<template>
  <div
    class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden"
  >
    <div class="flex flex-column align-items-center justify-content-center">
      <img :src="logoUrl" alt="Sakai logo" class="mb-5 w-6rem flex-shrink-0" />
      <div
        style="
          border-radius: 56px;
          padding: 0.3rem;
          background: linear-gradient(
            180deg,
            var(--primary-color) 10%,
            rgba(33, 150, 243, 0) 30%
          );
        "
      >
        <div
          class="w-full surface-card py-8 px-5 sm:px-8"
          style="border-radius: 53px"
        >
          <div class="text-center mb-5">
            <div class="text-900 text-3xl font-medium mb-3">Registration</div>
          </div>

          <div>
            <!--alert-->
            <div v-if="notify" class="alert alert-warning" role="alert">
              Pendaftaran berhasil, silahkan login
            </div>
            <!--name-->
            <label for="name" class="block text-900 text-xl font-medium mb-2"
              >Nama</label
            >
            <InputText
              id="name"
              type="text"
              placeholder="Nama"
              class="w-full md:w-30rem mb-5"
              style="padding: 1rem"
              v-model="name"
            />
            <label for="email1" class="block text-900 text-xl font-medium mb-2"
              >Email</label
            >
            <InputText
              id="email1"
              type="text"
              placeholder="Email address"
              class="w-full md:w-30rem mb-5"
              style="padding: 1rem"
              v-model="email"
            />

            <label
              for="password1"
              class="block text-900 font-medium text-xl mb-2"
              >Password</label
            >
            <Password
              id="password1"
              v-model="password"
              placeholder="Password"
              :toggleMask="true"
              class="w-full mb-3"
              inputClass="w-full"
              :inputStyle="{ padding: '1rem' }"
            ></Password>

            <div
              class="flex align-items-center justify-content-between mb-5 gap-5"
            >
              <div class="flex align-items-center">
                <label for="rememberme1"></label>
              </div>
              <a
                @click="() => $router.push('/auth/login')"
                class="font-medium no-underline ml-2 text-right cursor-pointer"
                style="color: var(--primary-color)"
                >Login</a
              >
            </div>
            <Button
              @click="register_proses"
              label="Sign In"
              class="w-full p-3 text-xl"
            ></Button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <AppConfig simple />
</template>

<style scoped>
.pi-eye {
  transform: scale(1.6);
  margin-right: 1rem;
}

.pi-eye-slash {
  transform: scale(1.6);
  margin-right: 1rem;
}
</style>
