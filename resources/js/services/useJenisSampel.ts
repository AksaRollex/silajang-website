import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useJenisSampel(options = {}) {
    return useQuery({
        queryKey: ['jenis-sampel'],
        queryFn: () => axios.get("/master/jenis-sampel").then((res: any) => res.data.data),
        ...options
    });
}