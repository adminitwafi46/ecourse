import { createRouter, createWebHistory } from "vue-router";
import AppLayout from "@/layout/AppLayout.vue";
import { jwtDecode } from "jwt-decode";

//is authenticated
function isAuthenticated() {
  const token = localStorage.getItem("token");
  if (token) {
    const decodedToken = jwtDecode(token);
    const currentTime = Date.now() / 1000;
    // Jika token kadaluarsa, hapus token dari penyimpanan lokal
    if (decodedToken.exp < currentTime) {
      localStorage.removeItem("token");
      return false;
    }
    return true;
  }
  return false;
}

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      component: AppLayout,
      children: [
        {
          path: "/",
          name: "dashboard",
          component: () => import("@/views/Dashboard.vue"),
          meta: { requiresAuth: true },
        },
        //route list_kursus
        {
          path: "/list_kursus",
          name: "kursus",
          component: () => import("@/views/kursus/listKursus.vue"),
          meta: { requiresAuth: true },
        },
        {
          path: "/kelola_kursus",
          name: "formlayout",
          component: () => import("@/views/kursus/kelolaKursus.vue"),
          meta: { requiresAuth: true },
        },
        //kelola_kursus dengan parameter id
        {
          path: "/kelola_kursus_id/:id",
          name: "kelola_kursus_id",
          component: () => import("@/views/kursus/kelolaKursusId.vue"),
          meta: { requiresAuth: true },
        },
        //kelola kuis dengan parameter id
        {
          path: "/kelola_kuis_id/:id",
          name: "kelola_kuis_id",
          component: () => import("@/views/kursus/kelolaKuisId.vue"),
          meta: { requiresAuth: true },
        },
        {
          path: "/uikit/input",
          name: "input",
          component: () => import("@/views/uikit/Input.vue"),
        },
        {
          path: "/uikit/floatlabel",
          name: "floatlabel",
          component: () => import("@/views/uikit/FloatLabel.vue"),
        },
        {
          path: "/uikit/invalidstate",
          name: "invalidstate",
          component: () => import("@/views/uikit/InvalidState.vue"),
        },
        {
          path: "/uikit/button",
          name: "button",
          component: () => import("@/views/uikit/Button.vue"),
        },
        {
          path: "/uikit/table",
          name: "table",
          component: () => import("@/views/uikit/Table.vue"),
        },
        {
          path: "/uikit/list",
          name: "list",
          component: () => import("@/views/uikit/List.vue"),
        },
        {
          path: "/uikit/tree",
          name: "tree",
          component: () => import("@/views/uikit/Tree.vue"),
        },
        {
          path: "/uikit/panel",
          name: "panel",
          component: () => import("@/views/uikit/Panels.vue"),
        },

        {
          path: "/uikit/overlay",
          name: "overlay",
          component: () => import("@/views/uikit/Overlay.vue"),
        },
        {
          path: "/uikit/media",
          name: "media",
          component: () => import("@/views/uikit/Media.vue"),
        },
        {
          path: "/uikit/menu",
          component: () => import("@/views/uikit/Menu.vue"),
          children: [
            {
              path: "/uikit/menu",
              component: () => import("@/views/uikit/menu/PersonalDemo.vue"),
            },
            {
              path: "/uikit/menu/seat",
              component: () => import("@/views/uikit/menu/SeatDemo.vue"),
            },
            {
              path: "/uikit/menu/payment",
              component: () => import("@/views/uikit/menu/PaymentDemo.vue"),
            },
            {
              path: "/uikit/menu/confirmation",
              component: () =>
                import("@/views/uikit/menu/ConfirmationDemo.vue"),
            },
          ],
        },
        {
          path: "/uikit/message",
          name: "message",
          component: () => import("@/views/uikit/Messages.vue"),
        },
        {
          path: "/uikit/file",
          name: "file",
          component: () => import("@/views/uikit/File.vue"),
        },
        {
          path: "/uikit/charts",
          name: "charts",
          component: () => import("@/views/uikit/Chart.vue"),
        },
        {
          path: "/uikit/misc",
          name: "misc",
          component: () => import("@/views/uikit/Misc.vue"),
        },
        {
          path: "/blocks",
          name: "blocks",
          component: () => import("@/views/utilities/Blocks.vue"),
        },
        {
          path: "/utilities/icons",
          name: "icons",
          component: () => import("@/views/utilities/Icons.vue"),
        },
        {
          path: "/pages/timeline",
          name: "timeline",
          component: () => import("@/views/pages/Timeline.vue"),
        },
        {
          path: "/pages/empty",
          name: "empty",
          component: () => import("@/views/pages/Empty.vue"),
        },
        {
          path: "/pages/crud",
          name: "crud",
          component: () => import("@/views/pages/Crud.vue"),
        },
        {
          path: "/documentation",
          name: "documentation",
          component: () => import("@/views/utilities/Documentation.vue"),
        },
      ],
    },
    {
      path: "/landing",
      name: "landing",
      component: () => import("@/views/pages/Landing.vue"),
    },
    {
      path: "/pages/notfound",
      name: "notfound",
      component: () => import("@/views/pages/NotFound.vue"),
    },

    {
      path: "/auth/login",
      name: "login",
      component: () => import("@/views/pages/auth/Login.vue"),
    },
    {
      path: "/auth/access",
      name: "accessDenied",
      component: () => import("@/views/pages/auth/Access.vue"),
    },
    {
      path: "/auth/error",
      name: "error",
      component: () => import("@/views/pages/auth/Error.vue"),
    },
  ],
});
// Gunakan navigation guard untuk memeriksa autentikasi sebelum mengakses rute yang memerlukan otentikasi
router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    // Rute memerlukan otentikasi
    if (isAuthenticated()) {
      // Jika pengguna terautentikasi, izinkan akses
      next();
    } else {
      // Jika pengguna tidak terautentikasi, redirect ke halaman login
      next({ name: "login" });
    }
  } else {
    // Rute tidak memerlukan otentikasi, izinkan akses langsung
    next();
  }
});
export default router;
