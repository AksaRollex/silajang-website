import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useJabatan(options = {}) {
    return useQuery({
        queryKey: ['jabatan'],
        queryFn: () => axios.get("/master/jabatan").then((res: any) => res.data.data),
        ...options
    });
}