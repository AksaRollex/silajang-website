<template>
  <!--begin::Navbar-->
  <div class="app-navbar flex-shrink-0">
    <div class="app-navbar-item ms-1 ms-md-3 me-2 d-none d-md-flex">
      <span class="text-muted me-2 d-none d-md-inline">Preview Report</span>
      <i class="ki-duotone ki-document d-md-none fs-1 me-2">
        <i class="path1"></i>
        <i class="path2"></i>
      </i>
      <vswitch class="form-check-custom form-check-solid" :checked="previewReport"
        @change="setPreviewReport(!previewReport)">
      </vswitch>
    </div>
    <!--begin::Theme mode-->
    <div class="app-navbar-item ms-1 ms-md-3 me-2">
      <!--begin::Menu toggle-->
      <a href="#"
        class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
        data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
        data-kt-menu-placement="bottom-end">
        <KTIcon v-if="themeMode === 'light'" icon-name="night-day" icon-class="fs-2" />
        <KTIcon v-else icon-name="moon" icon-class="fs-2" />
      </a>
      <!--begin::Menu toggle-->
      <KTThemeModeSwitcher />
    </div>
    <!--end::Theme mode-->
    <!--begin::User menu-->
    <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
      <!--begin::Menu wrapper-->
      <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
        data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
        <img :src="user.photo ?? '/media/avatars/blank.png'" class="rounded-3" alt="user" style="object-fit: cover;" />
      </div>
      <KTUserMenu />
      <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->
  </div>
  <!--end::Navbar-->
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { computed, defineComponent } from "vue";
import KTUserMenu from "@/layouts/main-layout/menus/UserAccountMenu.vue";
import KTThemeModeSwitcher from "@/layouts/main-layout/theme-mode/ThemeModeSwitcher.vue";
import { ThemeModeComponent } from "@/assets/ts/layout";
import { useThemeStore } from "@/stores/theme";
import { useAuthStore } from "@/stores/auth";
import { usePreviewReport } from "@/stores/index";

export default defineComponent({
  name: "header-navbar",
  components: {
    KTUserMenu,
    KTThemeModeSwitcher,
  },
  setup() {
    const store = useThemeStore();
    const { user } = useAuthStore();
    const { previewReport, setPreviewReport } = usePreviewReport()

    const themeMode = computed(() => {
      if (store.mode === "system") {
        return ThemeModeComponent.getSystemMode();
      }
      return store.mode;
    });

    return {
      themeMode,
      getAssetPath,
      user,
      previewReport,
      setPreviewReport
    };
  },
});
</script>
