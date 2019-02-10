<template>
    <div class="columns">
        <div class="column">
            <div class="posts__post mg-t1 has-background-white columns is-flex"
                 :class="(userIdConnected == user.id) ? 'posts__post__delete' : null">
                <a href="void:javascript()" @click="deleteTweet($event)" class="delete-post"></a>
                <div class="column posts__post__left">
                    <a :href="/user/ + user.username">
                        <div class="posts__post__left__img"
                             style="background: url('https://via.placeholder.com/150') no-repeat center center"></div>
                    </a>
                </div>
                <div class="column posts__post__right">
                    <div class="level is-mobile posts__post__right__top has-text-left">
                        <div class="level-left">
                            <a :href="/user/ + user.username">
                                <strong class="posts__post__right__name">{{ user.name }}</strong>
                            </a>
                            <span class="posts__post__right__username">@{{ user.username }}</span>
                        </div>
                        <div class="level-right">
                            <span class="posts__post__right__date is-size-7">{{ post.human_date }}</span>
                        </div>
                    </div>
                    <div class="level">
                        <p class="has-text-black posts__post__right__content">{{ post.content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		name: "PostComponent",
		props: ['post', 'user', 'userIdConnected'],
		methods: {
			deleteTweet(event) {
				axios.get(`/api/user/delete-post/${this.post.id}`)
					.then((response) => console.log(response))
                    .then(() => {
	                    event.target.parentNode.parentNode.parentNode.remove();
                    })
                    .catch((error) => console.log(error))
			}
		}
	}
</script>