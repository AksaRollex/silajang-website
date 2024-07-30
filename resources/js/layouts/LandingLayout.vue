<template>
    <!-- begin::Navbar -->
    <nav class="navbar navbar-expand-lg bg-brand fixed-top navbar-dark" ref="navbar">
        <div class="container">
            <router-link class="navbar-brand fw-bold fs-2" to="/">
                <img v-if="setting?.logo_depan" :src="`${setting?.logo_depan}`" alt="Logo SI-LAJANG" class="w-50px me-4">
                <span>{{ setting?.app }}</span>
            </router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-n2" id="navbarNav">
                <ul class="navbar-nav ms-auto column-gap-6 column-gap-xl-10 p-4 p-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link py-3" to="/" exact-active-class="active">
                            {{ $t('nav.beranda') }}
                        </router-link>
                    </li>
                    <li v-if="layanans?.length" class="nav-item dropdown">
                        <router-link
                            :class="`nav-link dropdown-toggle py-3 ${location.pathname.includes('layanan') ? 'active' : ''}`"
                            to="" role="button" data-bs-toggle="dropdown">
                            {{ $t('nav.layanan') }}
                        </router-link>
                        <ul class="dropdown-menu">
                            <li v-for="layanan in layanans" :key="layanan.uuid">
                                <router-link class="dropdown-item" :to="`/layanan/${layanan.slug}`">
                                    {{ currentLang() === 'id' ? layanan.nama : layanan.nama_en }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="produkHukums?.length" class="nav-item dropdown">
                        <router-link
                            :class="`nav-link dropdown-toggle py-3 ${location.pathname.includes('produk-hukum') ? 'active' : ''}`"
                            to="" role="button" data-bs-toggle="dropdown">
                            {{ $t('nav.produk-hukum') }}
                        </router-link>
                        <ul class="dropdown-menu">
                            <li v-for="produk in produkHukums" :key="produk.uuid">
                                <router-link class="dropdown-item" :to="`/produk-hukum/${produk.slug}`">
                                    {{ produk.nama }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link py-3" to="/faq" exact-active-class="active">
                            {{ $t('nav.faq') }}
                        </router-link>
                    </li>
                    <!-- <li class="nav-item">
                        <router-link class="nav-link py-3" to="/tentang-kami" exact-active-class="active">
                            {{ $t('nav.tentang') }}
                        </router-link>
                    </li> -->
                    <li class="nav-item">
                        <router-link class="nav-link py-3" to="/kontak" exact-active-class="active">
                            {{ $t('nav.kontak') }}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn px-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <img v-if="currentLang() == 'id'" src="/media/indonesia.png" class="w-20px">
                                <img v-if="currentLang() == 'en'" src="/media/english.png" class="w-20px">
                            </button>
                            <div class="dropdown-menu">
                                <div class="dropdown-item p-0">
                                    <button class="btn btn-light w-100 text-start btn-sm rounded-0"
                                        @click="changeLang('id')">
                                        <img src="/media/indonesia.png" class="w-20px">
                                        <span class="ms-2">Indonesia</span>
                                    </button>
                                </div>
                                <div class="dropdown-item p-0">
                                    <button class="btn btn-light w-100 text-start btn-sm rounded-0"
                                        @click="changeLang('en')">
                                        <img src="/media/english.png" class="w-20px">
                                        <span class="ms-2">English</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li v-if="!isAuthenticated" class="nav-item mt-4 mt-md-0">
                        <router-link class="btn border py-3 text-white w-100 btn-login" to="/auth/sign-in">
                            <i class="las la-user fs-2 text-white"></i>
                            {{ $t('nav.login') }}
                        </router-link>
                    </li>
                    <li v-else class="nav-item mt-4 mt-md-0">
                        <a class="btn border py-3 text-white w-100 btn-login" href="/dashboard">
                            {{ $t('nav.masuk') }}
                            <i class="las la-arrow-right fs-2 text-white"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- end::Navbar -->

    <div style="margin-top: 72px"></div>
    <router-view></router-view>

    <!-- begin::CTA -->
    <section class="cta bg-brand py-10">
        <div class="container d-flex flex-wrap gap-8 align-items-center justify-content-between" style="max-width: 640px;">
            <h1 class="mb-0 me-20 text-white">{{ $t('cta.tanya') }}</h1>
            <router-link to="/kontak" class="btn bg-white text-brand flex-fill">{{ $t('cta.button')
            }}</router-link>
        </div>
    </section>
    <!-- end::CTA -->

    <!-- begin::Footer -->
    <footer class="footer bg-white py-20">
        <div class="container px-8">
            <div class="row gap-12">
                <div class="col-md-6">
                    <div class="d-flex gap-5 align-items-center mb-5">
                        <img class="footer-logo" :src="`${setting?.logo_depan}`" alt="Logo SI-LAJANG">
                        <img src="/media/bse.png" alt="Logo BSE" style="width: 175px">
                    </div>
                    <h3 class="text-brand">{{ setting?.app }}</h3>
                    <p class="text-black">{{ setting?.description }}</p>
                </div>
                <div class="col-lg-3 col-md-6 ms-auto">
                    <div class="mb-8 d-flex align-items-start gap-3">
                        <i class="las la-phone-alt text-brand fs-3"></i>
                        <div>
                            <h6 class="text-black">{{ $t('footer.telepon') }}</h6>
                            <div class="text-black">{{ setting?.telepon }}</div>
                        </div>
                    </div>
                    <div class="mb-8 d-flex align-items-start gap-3">
                        <i class="las la-envelope text-brand fs-3"></i>
                        <div>
                            <h6 class="text-black">{{ $t('footer.email') }}</h6>
                            <div class="text-black">{{ setting?.email }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <i class="las la-map-marked-alt text-brand fs-3"></i>
                        <div>
                            <h6 class="text-black">{{ $t('footer.alamat') }}</h6>
                            <div class="text-black">{{ setting?.alamat }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end::Footer -->

    <div class="modal fade" tabindex="-1" id="modal-pengumuman">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="mb-0">{{ $t('pengumuman') }}</h2>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-auto" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div v-for="pengumuman in pengumumans" :key="pengumuman.uuid" class="card mb-10">
                        <div class="card-header align-items-center min-h-50px py-4">
                            <h5 class="mb-0">
                                <span class="fw-normal fs-8" style="font-style: italic;">{{
                                    moment(pengumuman.created_at).format('DD-MM-YYYY')
                                }}</span>
                                <div>{{ currentLang() === 'id' ? pengumuman.judul : pengumuman.judul_en }}</div>
                            </h5>
                        </div>
                        <div class="card-body">
                            <article style="white-space: pre-line">
                                {{ currentLang() === 'id' ?
                                    pengumuman.isi : pengumuman.isi_en }}
                            </article>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ $t('tutup') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.navbar {
    transition: all 0.3s ease-in-out;

    .navbar-nav {
        @media (max-width: 992px) {
            margin-top: 1rem;
            background-color: #fff;
            border-radius: 0.25rem;

            a {
                color: #000;
            }
        }
    }

    .nav-link {
        position: relative;
        transition: 0.2s ease-in-out;

        @media (max-width: 992px) {
            &:hover {
                background-color: rgba($color: #0e0159, $alpha: 0.1);
            }
        }

        @media (min-width: 992px) {
            &::before {
                content: "";
                position: absolute;
                bottom: -5px;
                left: 0;
                width: 0;
                height: 2px;
                background-color: #fff;
                transition: all 0.3s ease-in-out;
            }

            &.active,
            &:hover {
                &::before {
                    width: 100%;
                }
            }
        }
    }

    .btn-login {
        @media (max-width: 992px) {
            color: #5b3eff !important;

            i {
                color: #5b3eff !important;
            }

            &:hover {
                color: #fff !important;

                i {
                    color: #fff !important;
                }
            }
        }
    }
}

.footer {
    &-logo {
        width: 100px;
    }
}
</style>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useLayanan, usePengumuman, useProdukHukum, useSetting } from "@/services";
import moment from "moment";

export default defineComponent({
    name: "landing-layout",
    setup() {
        const navbar = ref<HTMLElement | null>(null);
        const { isAuthenticated } = useAuthStore();
        const { data: setting } = useSetting();

        const { data: pengumumans = [] } = usePengumuman() as any;
        const { data: layanans = [] } = useLayanan() as any;
        const { data: produkHukums = [] } = useProdukHukum() as any;

        return {
            navbar,
            isAuthenticated,
            setting,
            pengumumans,
            moment,
            layanans,
            produkHukums,
            location: window.location,
        };
    },
    methods: {
        currentLang() {
            return localStorage.getItem("lang") || "id";
        },
        changeLang(lang: string) {
            localStorage.setItem("lang", lang);
            window.location.reload();
        },
    },
    watch: {
        pengumumans() {
            if (this.pengumumans.length) {
                $('#modal-pengumuman').modal('show');
            }
        }
    },
    mounted() {

    },
});
</script>
