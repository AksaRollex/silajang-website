<template>
    <main>
        <header class="py-20 my-20 text-brand text-center">
            <h1 class="fs-6x fw-bolder">{{ $t('kontak.heading') }}</h1>
            <h4 class="fw-normal">{{ $t('kontak.tagline') }}</h4>
            <div class="mx-auto bg-brand py-1 mt-10 d-inline-block w-100px"></div>
        </header>

        <section>
            <div class="d-flex align-items-md-center flex-column mb-20 pb-20 container px-10">
                <div class="d-flex flex-wrap gap-10 justify-content-center">
                    <div
                        class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-brand border-left-5 border-start min-w-300px mw-600px mb-10">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5 mb-8">
                            <span class="symbol-label">
                                <i class="fas fa-phone-alt fs-2x text-brand"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->

                        <!--begin::Stats-->
                        <div class="m-0">
                            <!--begin::Number-->
                            <a :href="`tel:${data.telepon}`" target="_blank"
                                class="text-brand fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{
                                    data?.telepon }}</a>
                            <!--end::Number-->

                            <!--begin::Desc-->
                            <span class="text-gray-500 fw-semibold fs-6">{{ $t('footer.telepon') }}</span>
                            <!--end::Desc-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <div
                        class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-brand border-left-5 border-start min-w-300px mw-600px mb-10">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5 mb-8">
                            <span class="symbol-label">
                                <i class="fas fa-envelope fs-2x text-brand"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->

                        <!--begin::Stats-->
                        <div class="m-0">
                            <!--begin::Number-->
                            <a :href="`mailto:${data.email}`" target="_blank"
                                class="text-brand fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{
                                    data?.email }}</a>
                            <!--end::Number-->

                            <!--begin::Desc-->
                            <span class="text-gray-500 fw-semibold fs-6">{{ $t('footer.email') }}</span>
                            <!--end::Desc-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <div
                        class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-brand border-left-5 border-start min-w-300px mw-600px mb-10">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5 mb-8">
                            <span class="symbol-label">
                                <i class="fas fa-map-marker-alt fs-2x text-brand"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->

                        <!--begin::Stats-->
                        <div class="m-0">
                            <!--begin::Number-->
                            <a href="https://goo.gl/maps/F67jngU8TUGWSuZb8" target="_blank"
                                class="text-brand fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{
                                    data?.alamat }}</a>
                            <!--end::Number-->

                            <!--begin::Desc-->
                            <span class="text-gray-500 fw-semibold fs-6">{{ $t('footer.alamat') }}</span>
                            <!--end::Desc-->
                        </div>
                        <!--end::Stats-->
                    </div>
                </div>
            </div>

            <div style="overflow:hidden;resize:none;max-width:100%;">
                <div id="google-maps-display" style="height:100%; width:100%;max-width:100%;">
                    <iframe style="height:480px;width:100%;border:0;" frameborder="0"
                        src="https://www.google.com/maps/embed/v1/place?q=-7.5379247,112.2406114&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8">
                    </iframe>
                </div>
            </div>
        </section>
    </main>
</template>

<style lang="scss" scoped>
header {
    position: relative;
    overflow: hidden;

    >* {
        position: relative;
        z-index: 1;
    }

    &::before {
        content: '';
        position: absolute;
        width: 75%;
        aspect-ratio: 1;
        border-radius: 50%;
        background-color: #f3f4f6;
        bottom: 0;
        left: 50%;
        transform: translate(-50%, 75%);
        z-index: 0;
    }
}
</style>

<script lang="ts">
import { useSetting } from '@/services'
import { defineComponent } from 'vue'

export default defineComponent({
    setup() {
        const { data = { value: {} } } = useSetting()

        return {
            data,
        }
    },
})
</script>
