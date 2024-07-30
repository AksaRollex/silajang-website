<template>
    <div class="row row-gap-8">
        <div class="col-xxl-3 col-xl-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-8 flex-wrap w-100">
                        <div class="symbol symbol-sm-100px symbol-lg-160px symbol-fixed position-relative">
                            <img :src="user.photo ?? '/media/avatars/blank.png'" style="object-fit: cover;">
                        </div>
                        <div class="d-flex flex-column w-100">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ user.nama }}</a>
                                <a><i class="ki-duotone ki-verify fs-1 text-primary"><span class="path1"></span><span
                                            class="path2"></span></i></a>
                            </div>
                            <!--end::Name-->

                            <!--begin::Info-->
                            <div class="d-flex flex-column fw-semibold fs-6 pe-2">
                                <a class="d-flex align-items-center text-gray-600 text-hover-primary mb-2">
                                    <i class="ki-duotone me-2 ki-sms fs-4"><span class="path1"></span><span
                                            class="path2"></span></i> {{ user.email }}
                                </a>
                                <a class="d-flex align-items-center text-gray-600 text-hover-primary mb-2">
                                    <i class="ki-duotone me-2 ki-phone fs-4"><span class="path1"></span><span
                                            class="path2"></span></i> {{ user.phone }}
                                </a>
                                <div class="border border-bottom border-gray my-4"></div>
                                <a class="d-flex align-items-center text-gray-600 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone me-2 ki-profile-circle fs-4 me-1"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></i> {{ user.golongan?.nama }}
                                </a>
                            </div>
                            <!--end::Info-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="xol-xxl-9 col-xl-8 col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row row-gap-8">
                        <div class="col-xxl-4 col-xl-5">
                            <ul class="nav nav-tabs nav-pills flex-row border-0 flex-md-column me-5 mb-3 mb-md-0 fs-6">
                                <li class="nav-item w-100 me-0 mb-md-2">
                                    <a class="nav-link w-100 active btn btn-flex btn-active-light-success"
                                        data-bs-toggle="tab" href="#tab-akun">
                                        <i class="ki-duotone ki-user-square fs-1">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                            <i class="path3"></i>
                                        </i>
                                        <span class="d-flex flex-column align-items-start ms-2">
                                            <span class="fs-4 fw-bold">Akun</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item w-100 me-0 mb-md-2">
                                    <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                                        href="#tab-perusahaan">
                                        <i class="ki-duotone ki-briefcase fs-1">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                        </i>
                                        <span class="d-flex flex-column align-items-start ms-2">
                                            <span class="fs-4 fw-bold">Perusahaan</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a class="nav-link w-100 btn btn-flex btn-active-light-danger" data-bs-toggle="tab"
                                        href="#tab-keamanan">
                                        <i class="ki-duotone ki-shield fs-1">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                        </i>
                                        <span class="d-flex flex-column align-items-start ms-2">
                                            <span class="fs-4 fw-bold">Keamanan</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xxl-8 col-xl-7">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab-akun" role="tabpanel">
                                    <Akun />
                                </div>
                                <div class="tab-pane fade" id="tab-perusahaan" role="tabpanel">
                                    <Perusahaan />
                                </div>
                                <div class="tab-pane fade" id="tab-keamanan" role="tabpanel">
                                    <Keamanan />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { useAuthStore } from "@/stores/auth";
import { defineComponent } from "vue";

import Akun from "./tabs/Akun.vue";
import Perusahaan from "./tabs/Perusahaan.vue";
import Keamanan from "./tabs/Keamanan.vue";

export default defineComponent({
    components: {
        Akun,
        Perusahaan,
        Keamanan
    },
    setup() {
        const { user } = useAuthStore();

        return {
            user
        };
    },
});
</script>
