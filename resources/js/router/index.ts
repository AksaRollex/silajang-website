import {
  createRouter,
  createWebHistory,
  type RouteRecordRaw,
} from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useConfigStore } from "@/stores/config";

/*
  meta: {
    middleware: "auth" | "guest",
    pageTitle: string,
    breadcrumbs: string[],
    permission?: string, // string = permission required in PermissionSeeder.php (if not set, no permission required)
  }
*/

const routes: Array<RouteRecordRaw> = [
  {
    path: "",
    component: () => import("@/layouts/LandingLayout.vue"),
    children: [
      {
        path: "",
        name: "home",
        component: () => import("@/pages/landing/Home.vue")
      },
      {
        path: "layanan/:slug",
        name: "layanan",
        component: () => import("@/pages/landing/Layanan.vue")
      },
      {
        path: "produk-hukum/:slug",
        name: "produk-hukum",
        component: () => import("@/pages/landing/ProdukHukum.vue")
      },
      {
        path: "faq",
        name: "faq",
        component: () => import("@/pages/landing/FAQ.vue")
      },
      {
        path: "kontak",
        name: "kontak",
        component: () => import("@/pages/landing/Kontak.vue")
      },
      {
        path: "peraturan",
        name: "peraturan",
        component: () => import("@/pages/landing/ProdukHukum.vue")
      }
    ]
  },

  // Dashboard
  {
    path: "/",
    component: () => import("@/layouts/main-layout/MainLayout.vue"),
    meta: {
      middleware: "auth",
    },
    children: [
      {
        path: "dashboard",
        name: "dashboard",
        component: () => import("@/pages/dashboard/Index.vue"),
      },
      {
        path: "dashboard/profile",
        name: "dashboard.profile",
        component: () => import("@/pages/dashboard/profile/Index.vue"),
        meta: {
          breadcrumbs: ["Profile"],
          checkDetail: false
        },
      },

      // Administrasi
      {
        path: "dashboard/administrasi/penerima-sample",
        name: "dashboard.administrasi.penerima-sample",
        component: () => import("@/pages/dashboard/pengujian/administrasi/penerima/Index.vue"),
        meta: {
          breadcrumbs: ["Administrasi", "Penerima Sampel"],
          permission: "penerima-sample",
        },
      },
      {
        path: "dashboard/administrasi/pengambil-sample",
        name: "dashboard.administrasi.pengambil-sample",
        component: () => import("@/pages/dashboard/pengujian/administrasi/pengambil/Index.vue"),
        meta: {
          breadcrumbs: ["Administrasi", "Pengambil Sampel"],
          permission: "pengambil-sample",
        },
      },
      {
        path: "dashboard/administrasi/persetujuan",
        name: "dashboard.administrasi.persetujuan",
        component: () => import("@/pages/dashboard/pengujian/administrasi/persetujuan/Index.vue"),
        meta: {
          breadcrumbs: ["Administrasi", "Persetujuan"],
          permission: "persetujuan",
        },
      },

      // Verifikasi
      {
        path: "dashboard/verifikasi/analis",
        name: "dashboard.verifikasi.analis",
        component: () => import("@/pages/dashboard/pengujian/verifikasi/analis/Index.vue"),
        meta: {
          breadcrumbs: ["Verifikasi", "Analis"],
          permission: "analis",
        },
      },
      {
        path: "dashboard/verifikasi/koordinator-teknis",
        name: "dashboard.verifikasi.koordinator-teknis",
        component: () => import("@/pages/dashboard/pengujian/verifikasi/koordinator-teknis/Index.vue"),
        meta: {
          breadcrumbs: ["Verifikasi", "Koordinator Teknis"],
          permission: "koordinator-teknis",
        },
      },
      {
        path: "dashboard/verifikasi/kepala-upt",
        name: "dashboard.verifikasi.kepala-upt",
        component: () => import("@/pages/dashboard/pengujian/verifikasi/kepala-upt/Index.vue"),
        meta: {
          breadcrumbs: ["Verifikasi", "Kepala UPT"],
          permission: "kepala-upt",
        },
      },

      // Report
      {
        path: "dashboard/report/lhu",
        name: "dashboard.report.lhu",
        component: () => import("@/pages/dashboard/pengujian/report/lhu/Index.vue"),
        meta: {
          breadcrumbs: ["Report", "Laporan Hasil Uji"],
          permission: "lhu",
        },
      },
      {
        path: "dashboard/report/kendali-mutu",
        name: "dashboard.report.kendali-mutu",
        component: () => import("@/pages/dashboard/pengujian/report/kendali-mutu/Index.vue"),
        meta: {
          breadcrumbs: ["Report", "Kendali Mutu"],
          permission: "kendali-mutu",
        },
      },
      {
        path: "dashboard/report/rekap-data",
        name: "dashboard.report.rekap-data",
        component: () => import("@/pages/dashboard/pengujian/report/rekap-data/Index.vue"),
        meta: {
          breadcrumbs: ["Report", "Rekap Data"],
          permission: "rekap-data",
        },
      },
      {
        path: "dashboard/report/registrasi-sampel",
        name: "dashboard.report.registrasi-sampel",
        component: () => import("@/pages/dashboard/pengujian/report/registrasi-sampel/Index.vue"),
        meta: {
          breadcrumbs: ["Report", "Registrasi Sampel"],
          permission: "registrasi-sampel",
        },
      },
      {
        path: "dashboard/report/rekap-parameter",
        name: "dashboard.report.rekap-parameter",
        component: () => import("@/pages/dashboard/pengujian/report/parameter/Index.vue"),
        meta: {
          breadcrumbs: ["Report", "Rekap Parameter"],
          permission: "rekap-parameter",
        },
      },

      // Pembayaran
      {
        path: "dashboard/pembayaran/multi-pembayaran",
        name: "dashboard.pembayaran.multi-pembayaran",
        component: () => import("@/pages/dashboard/pembayaran/multi-pembayaran/Index.vue"),
        meta: {
          breadcumbs: ["Pembayaran", "Multi Pembayaran"],
          permission: "pembayaran-multi-pembayaran",
        }
      },
      {
        path: "dashboard/pembayaran/pengujian",
        name: "dashboard.pembayaran.pengujian",
        component: () => import("@/pages/dashboard/pembayaran/pengujian/Index.vue"),
        meta: {
          breadcrumbs: ["Pembayaran", "Pengujian"],
          permission: "pembayaran-pengujian",
        },
      },
      {
        path: "dashboard/pembayaran/non-pengujian",
        name: "dashboard.pembayaran.non-pengujian",
        component: () => import("@/pages/dashboard/pembayaran/non-pengujian/Index.vue"),
        meta: {
          breadcrumbs: ["Pembayaran", "Non Pengujian"],
          permission: "pembayaran-non-pengujian",
        },
      },
      {
        path: "dashboard/pembayaran/global",
        name: "dashboard.pembayaran.global",
        component: () => import("@/pages/dashboard/pembayaran/global/Index.vue"),
        meta: {
          breadcrumbs: ["Pembayaran", "Global"],
          permission: "pembayaran-global",
        },
      },
      {
        path: "dashboard/pembayaran",
        name: "dashboard.pembayaran",
        component: () => import("@/pages/dashboard/pembayaran/customer/Index.vue"),
        meta: {
          breadcrumbs: ["Pembayaran", "Pengujian"],
          permission: "pembayaran-customer",
        },
      },

      // Master Data
      {
        path: "dashboard/master/acuan-metode",
        name: "dashboard.master.acuan-metode",
        component: () => import("@/pages/dashboard/master/acuan-metode/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Metode"],
          permission: "acuan-metode",
        },
      },
      {
        path: "dashboard/master/peraturan",
        name: "dashboard.master.peraturan",
        component: () => import("@/pages/dashboard/master/peraturan/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Peraturan"],
          permission: "peraturan",
        },
      },
      {
        path: "dashboard/master/paket",
        name: "dashboard.master.paket",
        component: () => import("@/pages/dashboard/master/paket/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Paket"],
          permission: "paket",
        },
      },
      {
        path: "dashboard/master/parameter",
        name: "dashboard.master.parameter",
        component: () => import("@/pages/dashboard/master/parameter/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "parameter"],
          permission: "parameter",
        },
      },
      {
        path: "dashboard/master/pengawetan",
        name: "dashboard.master.pengawetan",
        component: () => import("@/pages/dashboard/master/pengawetan/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Pengawetan"],
          permission: "pengawetan",
        },
      },
      {
        path: "dashboard/master/jenis-sampel",
        name: "dashboard.master.jenis-sampel",
        component: () => import("@/pages/dashboard/master/jenis-sampel/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Jenis Sampel"],
          permission: "jenis-sampel",
        },
      },
      {
        path: "dashboard/master/jenis-wadah",
        name: "dashboard.master.jenis-wadah",
        component: () => import("@/pages/dashboard/master/jenis-wadah/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Jenis Wadah"],
          permission: "jenis-wadah",
        },
      },
      {
        path: "dashboard/master/jasa-pengambilan",
        name: "dashboard.master.jasa-pengambilan",
        component: () => import("@/pages/dashboard/master/jasa-pengambilan/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Jasa Pengambilan"],
          permission: "jasa-pengambilan",
        },
      },
      {
        path: "dashboard/master/radius-pengambilan",
        name: "dashboard.master.radius-pengambilan",
        component: () => import("@/pages/dashboard/master/radius-pengambilan/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Radius Pengambilan"],
          permission: "radius-pengambilan",
        },
      },
      {
        path: "dashboard/master/libur-cuti",
        name: "dashboard.master.libur-cuti",
        component: () => import("@/pages/dashboard/master/libur-cuti/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Libur Cuti"],
          permission: "libur-cuti",
        },
      },
      {
        path: "dashboard/master/kode-retribusi",
        name: "dashboard.master.kode-retribusi",
        component: () => import("@/pages/dashboard/master/kode-retribusi/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Kode Retribusi"],
          permission: "kode-retribusi",
        },
      },

      // Master User
      {
        path: "dashboard/user/jabatan",
        name: "dashboard.user.jabatan",
        component: () => import("@/pages/dashboard/user/jabatan/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Jabatan"],
          permission: "jabatan",
        },
      },
      {
        path: "dashboard/user/user",
        name: "dashboard.user.user",
        component: () => import("@/pages/dashboard/user/user/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "User"],
          permission: "user",
        },
      },

      // Master Wilayah
      {
        path: "dashboard/wilayah/kota-kabupaten",
        name: "dashboard.wilayah.kota-kabupaten",
        component: () => import("@/pages/dashboard/wilayah/kota-kabupaten/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Kota/Kabupaten"],
          permission: "kota-kabupaten",
        },
      },
      {
        path: "dashboard/wilayah/kecamatan",
        name: "dashboard.wilayah.kecamatan",
        component: () => import("@/pages/dashboard/wilayah/kecamatan/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Kecamatan"],
          permission: "kecamatan",
        },
      },
      {
        path: "dashboard/wilayah/kelurahan",
        name: "dashboard.wilayah.kelurahan",
        component: () => import("@/pages/dashboard/wilayah/kelurahan/Index.vue"),
        meta: {
          breadcrumbs: ["Master", "Jabatan"],
          permission: "kelurahan",
        },
      },

      // Konfigurasi
      {
        path: "dashboard/konfigurasi/log-tte",
        name: "dashboard.konfigurasi.log-tte",
        component: () => import("@/pages/dashboard/konfigurasi/log-tte/Index.vue"),
        meta: {
          breadcrumbs: ["Konfigurisi", "Pengujian", "Log TTE"],
          permission: "log-tte",
        },
      },
      {
        path: "dashboard/konfigurasi/tanda-tangan",
        name: "dashboard.konfigurasi.tanda-tangan",
        component: () => import("@/pages/dashboard/konfigurasi/tanda-tangan/Index.vue"),
        meta: {
          breadcrumbs: ["Konfigurisi", "Pengujian", "Tanda Tangan"],
          permission: "tanda-tangan",
        },
      },
      {
        path: "dashboard/konfigurasi/umpan-balik",
        name: "dashboard.konfigurasi.umpan-balik",
        component: () => import("@/pages/dashboard/konfigurasi/umpan-balik/Index.vue"),
        meta: {
          breadcrumbs: ["Konfigurisi", "Pengujian", "Umpan Balik"],
          permission: "umpan-balik",
        },
      },
      {
        path: "dashboard/konfigurasi/tracking-pengujian",
        name: "dashboard.konfigurasi.tracking-pengujian",
        component: () => import("@/pages/dashboard/konfigurasi/tracking/Index.vue"),
        meta: {
          breadcrumbs: ["Konfigurisi", "Pengujian", "Umpan Balik"],
          permission: "tracking-pengujian",
        },
      },
      {
        path: "dashboard/konfigurasi/setting",
        name: "dashboard.konfigurasi.setting",
        component: () => import("@/pages/dashboard/konfigurasi/setting/Index.vue"),
        meta: {
          breadcrumbs: ["Konfigurisi", "Website", "Setting"],
          permission: "setting",
        },
      },
      {
        path: "dashboard/konfigurasi/banner",
        name: "dashboard.konfigurasi.banner",
        component: () => import("@/pages/dashboard/konfigurasi/banner/Index.vue"),
        meta: {
          breadcrumbs: ["Konfigurisi", "Website", "Banner"],
          permission: "banner",
        },
      },
      {
        path: "dashboard/konfigurasi/layanan",
        name: "dashboard.konfigurasi.layanan",
        component: () => import("@/pages/dashboard/konfigurasi/layanan/Index.vue"),
        meta: {
          breadcrumbs: ["Konfigurisi", "Website", "Layanan"],
          permission: "layanan",
        },
      },
      {
        path: "dashboard/konfigurasi/produk-hukum",
        name: "dashboard.konfigurasi.produk-hukum",
        component: () => import("@/pages/dashboard/konfigurasi/produk-hukum/Index.vue"),
        meta: {
          breadcrumbs: ["Konfigurisi", "Website", "Produk Hukum"],
          permission: "produk-hukum",
        },
      },
      {
        path: "dashboard/konfigurasi/faq",
        name: "dashboard.konfigurasi.faq",
        component: () => import("@/pages/dashboard/konfigurasi/faq/Index.vue"),
        meta: {
          breadcrumbs: ["Konfigurisi", "Website", "FAQ"],
          permission: "faq",
        },
      },
      {
        path: "dashboard/konfigurasi/pengumuman",
        name: "dashboard.konfigurasi.pengumuman",
        component: () => import("@/pages/dashboard/konfigurasi/pengumuman/Index.vue"),
        meta: {
          breadcrumbs: ["Konfigurisi", "Website", "Pengumuman"],
          permission: "pengumuman",
        },
      },
      {
        path: "dashboard/konfigurasi/whatsapp",
        name: "dashboard.konfigurasi.whatsapp",
        component: () => import("@/pages/dashboard/konfigurasi/whatsapp/Index.vue"),
        meta: {
          breadcrumbs: ["Konfigurisi", "Website", "WhatsApp"],
          permission: "whatsapp",
        },
      },

      // Dashboard User
      {
        path: "dashboard/pengujian/permohonan",
        name: "dashboard.pengujian.permohonan",
        component: () => import("@/pages/dashboard/pengujian/permohonan/Index.vue"),
        meta: {
          breadcrumbs: ["Pengujian", "Permohonan"],
          permission: "permohonan",
        },
      },
      {
        path: "dashboard/pengujian/permohonan/:uuid",
        name: "dashboard.pengujian.permohonan.titik",
        component: () => import("@/pages/dashboard/pengujian/permohonan/titik/Index.vue"),
        meta: {
          breadcrumbs: ["Pengujian", "Permohonan", "Titik Pengujian"],
          permission: "titik-permohonan",
        },
      },
      {
        path: "dashboard/pengujian/tracking",
        name: "dashboard.pengujian.tracking",
        component: () => import("@/pages/dashboard/pengujian/tracking/Index.vue"),
        meta: {
          breadcrumbs: ["Pengujian", "Tracking"],
          permission: "tracking-pengujian-customer",
        },
      },
    ],
  },
  {
    path: "/auth",
    redirect: "/auth/sign-in",
    component: () => import("@/layouts/AuthLayout.vue"),
    children: [
      {
        path: "/auth/sign-in",
        name: "sign-in",
        component: () =>
          import("@/pages/auth/sign-in/Index.vue"),
        meta: {
          pageTitle: "Sign In",
          middleware: "guest"
        },
      },
      {
        path: "/auth/sign-up",
        name: "sign-up",
        component: () =>
          import("@/pages/auth/sign-up/Index.vue"),
        meta: {
          pageTitle: "Sign Up",
          middleware: "guest"
        },
      },
    ],
  },
  {
    path: "/",
    component: () => import("@/layouts/SystemLayout.vue"),
    children: [
      {
        // the 404 route, when none of the above matches
        path: "/404",
        name: "404",
        component: () => import("@/pages/error/Error404.vue"),
        meta: {
          pageTitle: "Error 404",
        },
      },
      {
        path: "/500",
        name: "500",
        component: () => import("@/pages/error/Error500.vue"),
        meta: {
          pageTitle: "Error 500",
        },
      },
    ],
  },
  {
    path: "/:pathMatch(.*)*",
    redirect: "/404",
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

import NProgress from 'nprogress';
import 'nprogress/nprogress.css'

router.beforeEach(async (to, from, next) => {
  if (to.name) {
    // Start the route progress bar.
    NProgress.start()
  }

  const authStore = useAuthStore();
  const configStore = useConfigStore();

  // current page view title
  if (to.meta.pageTitle) {
    document.title = `${to.meta.pageTitle} - ${import.meta.env.VITE_APP_NAME}`;
  } else {
    document.title = import.meta.env.VITE_APP_NAME as string;
  }

  // reset config to initial state
  configStore.resetLayoutConfig();

  // verify auth token before each page change
  if (!authStore.isAuthenticated) await authStore.verifyAuth();

  // before page access check if page requires authentication
  if (to.meta.middleware == "auth") {
    if (authStore.isAuthenticated) {
      if (to.meta.permission && !authStore.user.permission.includes(to.meta.permission)) {
        next({ name: "404" });
      } else if (authStore.user.detail || to.meta.checkDetail == false || authStore.user.role?.name == "admin" || authStore.user.golongan_id == 2) {
        next();
      } else {
        next({ name: "dashboard.profile" });
      }
    } else {
      next({ name: "sign-in" });
    }
  } else if (to.meta.middleware == "guest" && authStore.isAuthenticated) {
    next({ name: "dashboard" });
  } else {
    next();
  }

  // Scroll page to top on every route change
  window.scrollTo({
    top: 0,
    left: 0,
    behavior: "smooth",
  });
});

router.afterEach(() => {
  // Complete the animation of the route progress bar.
  NProgress.done()
})


export default router;
