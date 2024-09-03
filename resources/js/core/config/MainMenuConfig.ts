export interface MenuItem {
  heading?: string;
  sectionTitle?: string;
  route?: string[] | string;
  pages?: Array<MenuItem>;
  keenthemesIcon?: string;
  bootstrapIcon?: string;
  sub?: Array<MenuItem>;
  name?: string;
}

const MainMenuConfig: Array<MenuItem> = [
  {
    pages: [
      {
        heading: "Dashboard",
        name: "dashboard",
        route: "/dashboard",
        keenthemesIcon: "element-11",
      },
    ],
  },

  // Pengujian
  {
    heading: "Pengujian",
    name: "pengujian",
    route: ["/dashboard/administrasi", "/dashboard/verifikasi", "/dashboard/report"],
    pages: [
      {
        sectionTitle: "Administrasi",
        route: "/dashboard/administrasi",
        keenthemesIcon: "monitor-mobile",
        name: "administrasi",
        sub: [
          {
            heading: "Kontrak",
            name: "kontrak",
            route: "/dashboard/administrasi/kontrak",
          },
          {
            heading: "Persetujuan",
            name: "persetujuan",
            route: "/dashboard/administrasi/persetujuan",
          },
          {
            heading: "Pengambil Sampel",
            name: "pengambil-sample",
            route: "/dashboard/administrasi/pengambil-sample",
          },
          {
            heading: "Penerima Sampel",
            name: "penerima-sample",
            route: "/dashboard/administrasi/penerima-sample",
          },
        ],
      },
      {
        sectionTitle: "Verifikasi",
        route: "/verifikasi",
        keenthemesIcon: "shield-tick",
        name: "verifikasi",
        sub: [
          {
            heading: "Analis",
            name: "analis",
            route: "/dashboard/verifikasi/analis",
          },
          {
            heading: "Koordinator Teknis",
            name: "koordinator-teknis",
            route: "/dashboard/verifikasi/koordinator-teknis",
          },
          {
            heading: "Kepala UPT",
            name: "kepala-upt",
            route: "/dashboard/verifikasi/kepala-upt",
          },
        ],
      },
      {
        sectionTitle: "Report",
        route: "/report",
        keenthemesIcon: "document",
        name: "report",
        sub: [
          {
            heading: "Laporan Hasil Pengujian",
            name: "lhu",
            route: "/dashboard/report/lhu",
          },
          {
            heading: "Kendali Mutu",
            name: "kendali-mutu",
            route: "/dashboard/report/kendali-mutu",
          },
          {
            heading: "Registrasi Sampel",
            name: "registrasi-sampel",
            route: "/dashboard/report/registrasi-sampel",
          },
          {
            heading: "Rekap Data",
            name: "rekap-data",
            route: "/dashboard/report/rekap-data",
          },
          {
            heading: "Rekap Parameter",
            name: "rekap-parameter",
            route: "/dashboard/report/rekap-parameter",
          },
        ],
      },
      {
        heading: "Permohonan",
        name: "permohonan",
        route: "/dashboard/pengujian/permohonan",
        keenthemesIcon: "book-square",
      },
      {
        heading: "Tracking Pengujian",
        name: "tracking-pengujian-customer",
        route: "/dashboard/pengujian/tracking",
        keenthemesIcon: "search-list",
      },
    ]
  },

  // Pembayaran
  {
    pages: [
      {
        heading: "Pembayaran",
        name: "pembayaran-customer",
        route: "/dashboard/pembayaran",
        meta: {
          golonganId: 1
        }
      },
    ],
  },
  {
    heading: "Pembayaran",
    name: "pembayaran",
    route: "/dashboard/pembayaran",
    pages: [
      {
        heading: "Pengujian",
        name: "pembayaran-pengujian",
        keenthemesIcon: "wallet",
        route: "/dashboard/pembayaran/pengujian",
      },
      {
        heading: "Non Pengujian",
        name: "pembayaran-non-pengujian",
        keenthemesIcon: "credit-cart",
        route: "/dashboard/pembayaran/non-pengujian",
      },
      {
        heading: "Global",
        name: "pembayaran-global",
        keenthemesIcon: "bank",
        route: "/dashboard/pembayaran/global",
      }
    ]
  },

  // Master Data
  {
    heading: "Master",
    name: "master",
    route: ["/dashboard/master", "/dashboard/user", "/dashboard/wilayah"],
    pages: [
      {
        sectionTitle: "Master",
        route: "/master",
        keenthemesIcon: "cube-3",
        name: "master",
        sub: [
          {
            heading: "Metode",
            name: "acuan-metode",
            route: "/dashboard/master/acuan-metode",
          },
          {
            heading: "Peraturan",
            name: "peraturan",
            route: "/dashboard/master/peraturan",
          },
          {
            heading: "Parameter",
            name: "parameter",
            route: "/dashboard/master/parameter",
          },
          {
            heading: "Paket",
            name: "paket",
            route: "/dashboard/master/paket",
          },
          {
            heading: "Pengawetan",
            name: "pengawetan",
            route: "/dashboard/master/pengawetan",
          },
          {
            heading: "Jenis Sampel",
            name: "jenis-sampel",
            route: "/dashboard/master/jenis-sampel",
          },
          {
            heading: "Jenis Wadah",
            name: "jenis-wadah",
            route: "/dashboard/master/jenis-wadah",
          },
          {
            heading: "Jasa Pengambilan",
            name: "jasa-pengambilan",
            route: "/dashboard/master/jasa-pengambilan",
          },
          {
            heading: "Radius Pengambilan",
            name: "radius-pengambilan",
            route: "/dashboard/master/radius-pengambilan",
          },
          {
            heading: "Libur Cuti",
            name: "libur-cuti",
            route: "/dashboard/master/libur-cuti",
          },
          {
            heading: "Kode Retribusi",
            name: "kode-retribusi",
            route: "/dashboard/master/kode-retribusi",
          },
        ],
      },
      {
        sectionTitle: "User",
        route: "/user",
        keenthemesIcon: "profile-user",
        name: "user",
        sub: [
          {
            heading: "Jabatan",
            name: "jabatan",
            route: "/dashboard/user/jabatan",
          },
          {
            heading: "User",
            name: "user",
            route: "/dashboard/user/user",
          },
        ],
      },
      {
        sectionTitle: "Wilayah",
        route: "/wilayah",
        keenthemesIcon: "map",
        name: "wilayah",
        sub: [
          {
            heading: "Kota/Kabupaten",
            name: "kota-kabupaten",
            route: "/dashboard/wilayah/kota-kabupaten",
          },
          {
            heading: "Kecamatan",
            name: "kecamatan",
            route: "/dashboard/wilayah/kecamatan",
          },
          {
            heading: "Kelurahan",
            name: "kelurahan",
            route: "/dashboard/wilayah/kelurahan",
          },
        ],
      },
    ]
  },

  // Konfigurasi
  {
    heading: "Konfigurasi",
    name: "konfigurasi",
    route: "/dashboard/konfigurasi",
    pages: [
      {
        sectionTitle: "Pengujian",
        route: "/pengujian",
        keenthemesIcon: "glass",
        name: "konfigurasi-pengujian",
        sub: [
          {
            heading: "Log TTE",
            name: "log-tte",
            route: "/dashboard/konfigurasi/log-tte",
          },
          {
            heading: "Tanda Tangan",
            name: "tanda-tangan",
            route: "/dashboard/konfigurasi/tanda-tangan",
          },
          {
            heading: "Umpan Balik",
            name: "umpan-balik",
            route: "/dashboard/konfigurasi/umpan-balik",
          },
          {
            heading: "Tracking Pengujian",
            name: "tracking-pengujian",
            route: "/dashboard/konfigurasi/tracking-pengujian",
          },
        ],
      },
      {
        sectionTitle: "Website",
        route: "/website",
        keenthemesIcon: "devices",
        name: "website",
        sub: [
          {
            heading: "Setting",
            name: "setting",
            route: "/dashboard/konfigurasi/setting",
          },
          {
            heading: "Banner",
            name: "banner",
            route: "/dashboard/konfigurasi/banner",
          },
          {
            heading: "Layanan",
            name: "layanan",
            route: "/dashboard/konfigurasi/layanan",
          },
          {
            heading: "Produk Hukum",
            name: "produk-hukum",
            route: "/dashboard/konfigurasi/produk-hukum",
          },
          {
            heading: "FAQ",
            name: "faq",
            route: "/dashboard/konfigurasi/faq",
          },
          {
            heading: "Pengumuman",
            name: "pengumuman",
            route: "/dashboard/konfigurasi/pengumuman",
          },
          {
            heading: "Whatsapp",
            name: "whatsapp",
            route: "/dashboard/konfigurasi/whatsapp",
          },
        ],
      },
    ]
  },
];

export default MainMenuConfig;
