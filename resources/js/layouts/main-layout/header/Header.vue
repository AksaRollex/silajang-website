<template>
  <!--begin::Header-->
  <div v-if="headerDisplay" id="kt_app_header" class="app-header">
    <!--begin::Header container-->
    <div class="app-container d-flex align-items-stretch justify-content-between" :class="{
      'container-fluid': headerWidthFluid,
      'container-xxl': !headerWidthFluid,
    }">
      <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
        <!--begin::Header menu toggle-->
        <div class="app-navbar-item d-lg-none me-2">
          <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
            <KTIcon icon-name="element-4" icon-class="fs-2" />
          </div>
        </div>
        <!--end::Header menu toggle-->
        <a href="/">
          <img v-if="themeMode === 'light' && layout === 'light-header'" alt="Logo" :src="setting?.logo_dalam"
            class="h-30px h-lg-45px app-sidebar-logo-default theme-light-show" />
          <img v-if="layout === 'dark-header' ||
            (themeMode === 'dark' && layout === 'light-header')
            " alt="Logo" :src="setting?.logo_dalam" class="h-30px h-lg-45px app-sidebar-logo-default" />
        </a>
      </div>
      <!--begin::Header wrapper-->
      <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
        <KTHeaderMenu />
        <KTHeaderNavbar />
      </div>
      <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
  </div>
  <!--end::Header-->
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent } from "vue";
import KTHeaderMenu from "@/layouts/main-layout/header/menu/Menu.vue";
import KTHeaderNavbar from "@/layouts/main-layout/header/Navbar.vue";
import {
  headerDisplay,
  headerWidthFluid,
  layout,
  themeMode,
  headerDesktopFixed,
  headerMobileFixed,
} from "@/core/helpers/config";
import { useSetting } from "@/services";

export default defineComponent({
  name: "layout-header",
  components: {
    KTHeaderMenu,
    KTHeaderNavbar,
  },
  setup() {
    const { data: setting = {} } = useSetting()

    return {
      layout,
      headerWidthFluid,
      headerDisplay,
      themeMode,
      getAssetPath,
      headerDesktopFixed,
      headerMobileFixed,
      setting
    };
  },
});
</script>
