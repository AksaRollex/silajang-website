import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function usePaket(options = {}) {
    return useQuery({
        queryKey: ['paket'],
        queryFn: () => axios.get("/master/paket").then((res: any) => res.data.data),
        ...options
    });
}