import { createRouter, createWebHistory } from "vue-router";
import AppLayout2 from "@/layout/AppLayout2.vue";
import AppLayout from "@/layout/AppLayout.vue";

//import AppLayout2 from "@/layout/AppLayout2.vue";
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
    //buat untuk komponen AppLayout2
    {
      path: "/learning",
      component: AppLayout2,
      children: [
        {
          path: "/learn_now/:id",
          name: "LearnNow",
          component: () => import("@/views/courses/LearnNow.vue"),
          meta: { requiresAuth: true },
        },
        //learnId
        {
          path: "/learn_id/:id",
          name: "learnId",
          component: () => import("@/views/courses/LearnId.vue"),
          meta: { requiresAuth: true },
        },
      ],
    },
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
        //available_courses
        {
          path: "/available_courses",
          name: "available_courses",
          component: () => import("@/views/courses/AvailableCourses.vue"),
          meta: { requiresAuth: true },
        },
        //course_detail dengan parameter id
        {
          path: "/course_detail/:id",
          name: "course_detail",
          component: () => import("@/views/courses/CourseDetail.vue"),
          meta: { requiresAuth: true },
        },
        //tagihan
        {
          path: "/tagihan",
          name: "tagihan",
          component: () => import("@/views/payments/Tagihan.vue"),
          meta: { requiresAuth: true },
        },
        //tagihan_detail dengan parameter invoice
        {
          path: "/tagihan_detail/:invoice",
          name: "tagihan_detail",
          component: () => import("@/views/payments/TagihanDetail.vue"),
          meta: { requiresAuth: true },
        },
        //my_courses
        {
          path: "/my_courses",
          name: "my_courses",
          component: () => import("@/views/courses/MyCourses.vue"),
          meta: { requiresAuth: true },
        },

        //profile
        {
          path: "/profile",
          name: "profile",
          component: () => import("@/views/users/Profile.vue"),
          meta: { requiresAuth: true },
        },
        {
          path: "/uikit/formlayout",
          name: "formlayout",
          component: () => import("@/views/uikit/FormLayout.vue"),
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
      path: "/auth/register",
      name: "register",
      component: () => import("@/views/pages/auth/Register.vue"),
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
