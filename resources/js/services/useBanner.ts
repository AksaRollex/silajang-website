import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useBanner(options = {}) {
    return useQuery({
        queryKey: ['banner'],
        queryFn: () => axios.get("/konfigurasi/banner").then((res: any) => res.data.data),
        ...options
    });
}