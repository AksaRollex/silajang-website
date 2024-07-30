import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function usePetugasPengambil(options = {}) {
    return useQuery({
        queryKey: ['petugas-pengambil'],
        queryFn: () => axios.get("/administrasi/pengambil-sample/petugas").then((res: any) => res.data.data),
        ...options
    });
}