import { createI18n } from "vue-i18n";

const messages = {
  id: {
    nav: {
      beranda: 'Beranda',
      layanan: 'Layanan',
      faq: 'FAQ',
      tentang: 'Tentang Kami',
      'produk-hukum': 'Produk Hukum',
      kontak: 'Kontak',
      login: 'Login',
      masuk: 'Masuk',
    },
    cta: {
      tanya: 'Ada yang ingin Anda tanyakan?',
      button: 'Hubungi Kami',
    },
    footer: {
      telepon: 'Telepon',
      email: 'Email',
      alamat: 'Alamat',
    },

    beranda: {
      masuk: 'Masuk',
      daftar: 'Daftar Pengujian',
      'umpan-balik': 'Indeks Kepuasan Masyarakat Layanan Pengujian Laboratorium',
      'ikm': 'IKM Unit Pelayanan',
      'responden': 'Jumlah Responden',
    },
    faq: {
      tagline: 'Pertanyaan Umum? Kami Punya Jawabannya!',
      tutorial: 'Petunjuk Penggunaan Aplikasi SI-LAJANG',
      manual_book: 'Unduh Manual Book'
    },
    kontak: {
      heading: 'Hubungi Kami',
      tagline: 'Tim kami tersedia untuk memberikan dukungan dan informasi yang Anda butuhkan.'
    },
    'produk-hukum': {
      heading: 'Produk Hukum',
      tagline: 'Produk Hukum yang dimiliki oleh Laboratorium DLH Kabupaten Jombang',
    },

    login: {
      heading: 'Masuk ke',
      email: 'Email',
      telepon: 'No. Telepon',
      remember: 'Tetap Login',
      otp: 'Kode OTP',
      otp_label: 'Tidak menerima kode OTP?',
      otp_resend: 'Kode OTP dapat dikirim ulang dalam',
      otp_detik: 'detik',
      otp_kirim: 'Kirim ulang',
      daftar_label: 'Belum memiliki akun?',
      daftar: 'Daftar',
    },

    tutup: 'Tutup',
    pengumuman: 'Pengumuman'
  },
  en: {
    nav: {
      beranda: 'Home',
      layanan: 'Services',
      faq: 'FAQ',
      tentang: 'About Us',
      'produk-hukum': 'Product of Law',
      kontak: 'Contact',
      login: 'Login',
      masuk: 'Get In',
    },
    cta: {
      tanya: 'Have any questions?',
      button: 'Contact Us',
    },
    footer: {
      telepon: 'Phone',
      email: 'Email',
      alamat: 'Address',
    },

    beranda: {
      masuk: 'Get In',
      daftar: 'Get Started',
      'umpan-balik': 'Public Satisfaction Index of Laboratory Testing Services',
      'ikm': 'IKM Service Unit',
      'responden': 'Number of Respondents',
    },
    faq: {
      tagline: "Got Questions? We've Got Answers!",
      tutorial: 'Instructions for Using the SI-LAJANG Application',
      manual_book: 'Download the Manual Book'
    },
    kontak: {
      heading: 'Contact Us',
      tagline: 'Our team is available to provide support and information you need.'
    },
    'produk-hukum': {
      heading: 'Product of Law',
      tagline: 'Product of Law owned by DLH Laboratory of Jombang Regency'
    },

    login: {
      heading: 'Sign In to',
      email: 'Email',
      telepon: 'Phone',
      remember: 'Remember Me',
      otp: 'OTP Code',
      otp_label: 'Didn\'t receive OTP code?',
      otp_resend: 'OTP code can be resend in',
      otp_detik: 'seconds',
      otp_kirim: 'Resend',
      daftar_label: 'Don\'t have an account?',
      daftar: 'Sign Up',
    },

    tutup: 'Close',
    pengumuman: 'Announcement'
  }
};

const i18n = createI18n({
  legacy: false,
  locale: localStorage.getItem("lang") || "id",
  globalInjection: true,
  messages,
});

export default i18n;
