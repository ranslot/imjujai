import { router } from "@inertiajs/vue3";

export function updateFollow(userId, isFollowed) {
    if (isFollowed) {
        router.delete(`/follow/${userId}`,
        )
    } else {
        router.post('/follow', { 'followed_user_id': userId },
        )
    }
}

export function markReadNotification(notificationId) {
    router.post(`/notification/${notificationId}`, {}, {
        onSuccess: () => {
            router.reload()
        }
    })
}