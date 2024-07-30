import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useLayanan(options = {}, slug: String | null | String[] = null) {
    return useQuery({
        queryKey: slug ? ["layanan", slug] : ["layanan"],
        queryFn: () => axios.get(slug ? `/konfigurasi/layanan/${slug}` : "/konfigurasi/layanan").then((res: any) => res.data.data),
        ...options
    });
}