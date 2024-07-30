<template>
  <template v-if="user?.permission && (user?.detail || user?.golongan_id == 2 || user?.role?.name == 'admin')">
    <template v-for="(item, i) in MainMenuConfig" :key="i">
      <template v-if="!item.heading">
        <template v-for="(menuItem, j) in item.pages" :key="j">
          <div v-if="menuItem.heading && checkPermission(menuItem.name, menuItem)" class="menu-item me-lg-1">
            <router-link v-if="menuItem.route" class="menu-link" :to="menuItem.route" active-class="active">
              <span class="menu-title">{{ translate(menuItem.heading) }}</span>
            </router-link>
          </div>
        </template>
      </template>
      <div v-if="item.heading && checkPermission(item.name, item)" data-kt-menu-trigger="click"
        data-kt-menu-placement="bottom-start"
        :class="`menu-item menu-lg-down-accordion me-lg-1 ${(item.name == 'pengujian' && user.role?.name == 'customer') ? 'd-none d-lg-flex' : ''}`">
        <span v-if="item.route" class="menu-link py-3" :class="{ active: hasActiveChildren(item.route) }">
          <span class="menu-title">{{ translate(item.heading) }}</span>
          <span class="menu-arrow d-lg-none"></span>
        </span>
        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
          <template v-for="(menuItem, j) in item.pages" :key="j">
            <div v-if="menuItem.sectionTitle && checkPermission(menuItem.name, menuItem)"
              data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start"
              class="menu-item menu-lg-down-accordion">
              <span v-if="menuItem.route" class="menu-link py-3" :class="{ active: hasActiveChildren(menuItem.route) }">
                <span class="menu-icon">
                  <i v-if="headerMenuIcons === 'bootstrap'" :class="menuItem.bootstrapIcon" class="bi fs-3"></i>
                  <KTIcon v-if="headerMenuIcons === 'keenthemes'" :icon-name="menuItem.keenthemesIcon"
                    icon-class="fs-2" />
                </span>
                <span class="menu-title">{{
                  translate(menuItem.sectionTitle)
                }}</span>
                <span class="menu-arrow"></span>
              </span>
              <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                <template v-for="(menuItem1, k) in menuItem.sub" :key="k">
                  <div v-if="menuItem1.sectionTitle && checkPermission(menuItem1.name, menuItem1)"
                    data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                    class="menu-item menu-lg-down-accordion">
                    <span v-if="menuItem1.route" class="menu-link py-3"
                      :class="{ active: hasActiveChildren(menuItem1.route) }">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">{{
                        translate(menuItem1.sectionTitle)
                      }}</span>
                      <span class="menu-arrow"></span>
                    </span>
                    <div
                      class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                      <template v-for="(menuItem2, l) in menuItem1.sub" :key="l">
                        <div v-if="checkPermission(menuItem2.name, menuItem2)" class="menu-item">
                          <router-link v-if="menuItem2.route && menuItem2.heading" class="menu-link py-3"
                            active-class="active" :to="menuItem2.route">
                            <span class="menu-bullet">
                              <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">{{
                              translate(menuItem2.heading)
                            }}</span>
                          </router-link>
                        </div>
                      </template>
                    </div>
                  </div>
                  <div v-if="menuItem1.heading && checkPermission(menuItem1.name, menuItem1)" class="menu-item">
                    <router-link v-if="menuItem1.route" class="menu-link" active-class="active" :to="menuItem1.route">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">{{
                        translate(menuItem1.heading)
                      }}</span>
                    </router-link>
                  </div>
                </template>
              </div>
            </div>
            <div v-if="menuItem.heading && checkPermission(menuItem.name, menuItem)" class="menu-item">
              <router-link v-if="menuItem.route && menuItem.route" class="menu-link" active-class="active"
                :to="menuItem.route">
                <span class="menu-icon">
                  <KTIcon v-if="headerMenuIcons === 'keenthemes'" :icon-name="menuItem.keenthemesIcon"
                    icon-class="fs-2" />
                </span>
                <span class="menu-title">{{ translate(menuItem.heading) }}</span>
              </router-link>
            </div>
          </template>
        </div>
      </div>
    </template>
    <div v-if="checkPermission('permohonan')" class="menu-item me-lg-1 d-lg-none">
      <router-link class="menu-link" to="/dashboard/pengujian/permohonan" active-class="active">
        <KTIcon icon-name="book-square" icon-class="fs-2" />
        <span class="menu-title ms-2">{{ translate('Permohonan') }}</span>
      </router-link>
    </div>
    <div v-if="checkPermission('tracking-pengujian-customer')" class="menu-item me-lg-1 d-lg-none">
      <router-link class="menu-link" to="/dashboard/pengujian/tracking" active-class="active">
        <KTIcon icon-name="search-list" icon-class="fs-2" />
        <span class="menu-title ms-2">{{ translate('Tracking Pengujian') }}</span>
      </router-link>
    </div>
  </template>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, computed } from "vue";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import MainMenuConfig from "@/core/config/MainMenuConfig";
import {
  headerMenuIcons,
  pageTitleBreadcrumbDisplay,
  pageTitleDirection,
  pageTitleDisplay,
} from "@/core/helpers/config";
import { useAuthStore } from "@/stores/auth";

export default defineComponent({
  name: "KTMenu",
  components: {},
  setup() {
    const { t, te } = useI18n();
    const route = useRoute();

    const pageTitle = computed(() => {
      return route.meta.pageTitle;
    });

    const breadcrumbs = computed(() => {
      return route.meta.breadcrumbs;
    });

    const hasActiveChildren = (match: string[] | string) => {
      if (Array.isArray(match)) {
        return match.some((item) => route.path.indexOf(item) !== -1);
      }

      return route.path.indexOf(match) !== -1;
    };

    const translate = (text: string) => {
      if (te(text)) {
        return t(text);
      } else {
        return text;
      }
    };

    const { user } = useAuthStore();

    return {
      hasActiveChildren,
      headerMenuIcons,
      MainMenuConfig,
      translate,
      getAssetPath,
      pageTitle,
      breadcrumbs,
      pageTitleDisplay,
      pageTitleBreadcrumbDisplay,
      pageTitleDirection,
      user
    };
  },
  methods: {
    checkPermission(menu, obj = {}) {
      if (obj.meta?.hasOwnProperty('golonganId')) {
        if (this.user?.golongan_id != obj.meta.golonganId) {
          return false;
        }
      }

      if (this.user?.permission?.includes(menu)) {
        return true;
      }
      return false;
    }
  }
});
</script>
