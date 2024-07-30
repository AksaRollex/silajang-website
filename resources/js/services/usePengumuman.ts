import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function usePengumuman(options = {}) {
    return useQuery({
        queryKey: ['pengumuman'],
        queryFn: () => axios.get("/konfigurasi/pengumuman").then((res: any) => res.data.data),
        ...options
    });
}