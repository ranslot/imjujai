import { router } from "@inertiajs/vue3";

export function updateLike(like, userLikes, updatePost) {
    let deleteLike = false;
    let id = null;

    for (let i = 0; i < userLikes.length; i++) {
        if (like.post.id === userLikes[i].post_id) {
            deleteLike = true;
            id = userLikes[i].id;
        }
    }

    if (deleteLike) {
        router.delete(`/likes/${id}`, {
            onFinish: () => updatePost(like),
        });
    } else {
        router.post(
            "/likes",
            {
                post_id: like.post.id,
            },
            {
                onFinish: () => updatePost(like),
            }
        );
    }
}

export function addComment(newComment, updatePost) {
    router.post(
        "/comments",
        {
            post_id: newComment.post.id,
            user_id: newComment.user.id,
            comment: newComment.comment,
        },
        {
            onFinish: () => updatePost(newComment),
        }
    );
}

export function deleteSelected(deleteTarget, updatePost) {
    if (deleteTarget.deleteType === "โพสต์") {
        router.delete(`/posts/${deleteTarget.id}`, {
            onFinish: () => updatePost(deleteTarget),
        });
    }

    if (deleteTarget.deleteType === "คอมเมนต์") {
        router.delete(`/comments/${deleteTarget.id}`, {
            onFinish: () => updatePost(deleteTarget),
        });
    }
}
