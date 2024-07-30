import { ref } from "vue";
import { defineStore } from "pinia";
import ApiService from "@/core/services/ApiService";
import JwtService from "@/core/services/JwtService";
import axios from "@/libs/axios";

export interface DetailUser {
  instansi: string;
  alamat: string;
  pimpinan: string;
  pj_mutu: string;
  telepon: string;
  fax: string;
  email: string;
  jenis_kegiatan: string;
  kab_kota_id: number | undefined | null;
  kecamatan_id: number | undefined | null;
  kelurahan_id: number | undefined | null;
  kecamatan: any;
  kelurahan: any;
  lat: number;
  long: number;
  tanda_tangan: string;
}

interface Golongan {
  nama: string;
}

export interface User {
  id: number;
  uuid: string;
  nama: string;
  email: string;
  password: string;
  phone: string;
  photo: string;
  permission: Array<string>;
  detail?: DetailUser,
  golongan?: Golongan,
  golongan_id?: number;
  has_umpan_balik: Boolean;
  role?: {
    name: string;
    full_name: string;
  };
}

export const useAuthStore = defineStore("auth", () => {
  const errors = ref({});
  const user = ref<User>({} as User);
  const isAuthenticated = ref(false);

  function setAuth(authUser: User, authToken = null) {
    isAuthenticated.value = true;
    user.value = authUser;
    errors.value = {};

    if (authToken) {
      JwtService.saveToken(authToken);
    }
  }

  function setError(error: any) {
    errors.value = { ...error };
  }

  function purgeAuth() {
    isAuthenticated.value = false;
    user.value = {} as User;
    errors.value = [];
    JwtService.destroyToken();
  }

  function login(credentials: User) {
    return ApiService.post("/auth/login", credentials)
      .then(({ data }) => {
        setAuth(data.user, data.token);
      })
      .catch(({ response }) => {
        setError(response.data.errors);
      });
  }

  function logout(callback: () => void) {
    axios.post("/auth/logout")
      .finally(() => {
        callback();
        purgeAuth();
      })
  }

  function register(credentials: User) {
    return ApiService.post("/auth/register", credentials)
      .then(({ data }) => {
        setAuth(data);
      })
      .catch(({ response }) => {
        setError(response.data.errors);
      });
  }

  function forgotPassword(email: string) {
    return ApiService.post("forgot_password", email)
      .then(() => {
        setError({});
      })
      .catch(({ response }) => {
        setError(response.data.errors);
      });
  }

  async function verifyAuth() {
    if (JwtService.getToken()) {
      ApiService.setHeader();
      try {
        const { data } = await ApiService.get("auth");
        setAuth(data.user);
      } catch (error: any) {
        setError(error.response.data.errors);
        purgeAuth();
      }
    } else {
      purgeAuth();
    }
  }

  return {
    errors,
    user,
    isAuthenticated,
    login,
    logout,
    register,
    forgotPassword,
    verifyAuth,
    setAuth,
    purgeAuth
  };
});
