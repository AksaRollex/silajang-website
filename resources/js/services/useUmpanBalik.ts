import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useUmpanBalik(options = {}) {
    return useQuery({
        queryKey: ['umpan-balik', 'keterangan'],
        queryFn: () => axios.get("/konfigurasi/umpan-balik/keterangan").then((res: any) => res.data),
        ...options
    });
}