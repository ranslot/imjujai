import { router } from "@inertiajs/vue3";

export function updateFollow(userId, isFollowed) {
    if (isFollowed) {
        router.delete(`/follow/${userId}`, { onSuccess: () => router.reload() })
    } else {
        router.post('/follow', { 'followed_user_id': userId }, { onSuccess: () => router.reload() })
    }
}