<template>
    <main>
        <header class="py-20 my-20 text-brand text-center">
            <h1 class="fs-6x fw-bolder">FAQs</h1>
            <h4 class="fw-normal">{{ $t('faq.tagline') }}</h4>
            <div class="mx-auto bg-brand py-1 mt-10 d-inline-block w-100px"></div>
        </header>

        <section class="mb-20 container px-5">
            <!--begin::Accordion-->
            <div class="accordion" id="accordion-faq">
                <div v-for="faq in faqs" :key="faq.uuid" class="accordion-item">
                    <h2 class="accordion-header" :id="`accordion-faq-header-${faq.uuid}`">
                        <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse"
                            :data-bs-target="`#accordion-faq-body-${faq.uuid}`"
                            :aria-controls="`accordion-faq-body-${faq.uuid}`">
                            {{ currentLang() === 'id' ? faq.pertanyaan : faq.pertanyaan_en }}
                        </button>
                    </h2>
                    <div :id="`accordion-faq-body-${faq.uuid}`" class="accordion-collapse collapse"
                        :aria-labelledby="`accordion-faq-header-${faq.uuid}`" data-bs-parent="#accordion-faq">
                        <div class="accordion-body">
                            <article style="white-space: pre-line">
                                {{ currentLang() === 'id' ? faq.jawaban : faq.jawaban_en }}
                            </article>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Accordion-->
        </section>

        <section class="mb-20 container text-center">
            <h2 class="mb-6">{{ $t('faq.tutorial') }}</h2>
            <div style="max-width: 768px;" class="mx-auto">
                <video id="player" playsinline controls>
                    <source src="/media/documentation.mp4" type="video/mp4" />
                </video>
            </div>
            <a href="/media/Manual Book Silajang - User.pdf" target="_blank"
                class="btn btn-light-brand border border-brand mt-4">
                <i class="la la-download fs-2"></i>
                {{ $t('faq.manual_book') }}
            </a>
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
import { useFAQ } from '@/services'
import { defineComponent } from 'vue'
import Plyr from 'plyr';
import 'plyr/dist/plyr.css'

export default defineComponent({
    setup() {
        const { data: faqs = [] } = useFAQ()

        return {
            faqs,
        }
    },
    methods: {
        currentLang() {
            return localStorage.getItem("lang") || "id";
        },
    },
    mounted() {
        const player = new Plyr('#player');
    }
})
</script>
