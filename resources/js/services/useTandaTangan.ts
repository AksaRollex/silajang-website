import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useTandaTangan(options = {}) {
    return useQuery({
        queryKey: ['tanda-tangan'],
        queryFn: () => axios.get("/konfigurasi/tanda-tangan").then((res: any) => res.data.data),
        ...options
    });
}