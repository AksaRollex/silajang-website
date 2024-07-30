<template>
  <!--begin::Footer-->
  <div v-if="footerDisplay" id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container d-flex flex-column flex-md-row flex-center flex-md-stack py-3" :class="{
      'container-fluid': footerWidthFluid,
      'container-xxl': !footerWidthFluid,
    }">
      <!--begin::Copyright-->
      <div class="text-dark order-2 order-md-1 mt-4">
        <span class="text-muted fw-semibold me-1">{{ new Date().getFullYear() }} ©</span>
        <router-link to="/" target="_blank" class="text-gray-800 text-hover-primary">{{ setting?.app }}</router-link>
        <div class="text-muted fs-8">{{ setting?.description }}</div>
      </div>
      <!--end::Copyright-->
    </div>
    <!--end::Footer container-->

    <div class="fab-whatsapp" data-toggle="tooltip" data-placement="top" title="Saran & Pengaduan Pengguna">
      <a href="https://wa.me/6285186863815" target="_blank" class="btn btn-icon">
        <i class="fab fa-whatsapp"></i>
      </a>
    </div>
  </div>
  <!--end::Footer-->
</template>

<style scoped>
.fab-whatsapp {
  position: fixed;
  bottom: 2.5rem;
  right: 4rem;
  z-index: 1030;
}

.fab-whatsapp .btn {
  width: 56px;
  height: 56px;
  background-color: #25D366;
  border-radius: 50%;
}

.fab-whatsapp .btn i {
  font-size: 2.5rem;
  color: #fff;
}

@media (max-width: 991.98px) {
  .fab-whatsapp {
    bottom: 1rem;
    right: 3.5rem;
  }

  .fab-whatsapp .btn {
    width: 48px;
    height: 48px;
  }

  .fab-whatsapp .btn i {
    font-size: 2rem;
  }
}
</style>

<script lang="ts">
import { defineComponent } from "vue";
import { footerDisplay, footerWidthFluid } from "@/core/helpers/config";
import { useSetting } from "@/services";
import { useAuthStore } from "@/stores/auth";

export default defineComponent({
  name: "theme-footer",
  components: {},
  setup() {
    const { data: setting = {} } = useSetting();
    const { user } = useAuthStore()

    return {
      footerWidthFluid,
      footerDisplay,
      setting,
      user
    };
  },
});
</script>
