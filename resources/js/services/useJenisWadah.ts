import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useJenisWadah(options = {}) {
    return useQuery({
        queryKey: ['jenis-wadah'],
        queryFn: () => axios.get("/master/jenis-wadah").then((res: any) => res.data.data),
        ...options
    });
}