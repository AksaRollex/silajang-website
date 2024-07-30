import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useKodeRetribusi(options = {}) {
    return useQuery({
        queryKey: ['kode-retribusi'],
        queryFn: () => axios.get("/master/kode-retribusi").then((res: any) => res.data.data),
        ...options
    });
}