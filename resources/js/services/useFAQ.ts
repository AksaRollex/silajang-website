import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useFAQ(options = {}) {
    return useQuery({
        queryKey: ['faq'],
        queryFn: () => axios.get("/konfigurasi/faq").then((res: any) => res.data.data),
        ...options
    });
}