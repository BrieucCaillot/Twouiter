<template>
    <main id="content" class="user posts background-color-primary has-text-white">
        <div class="container is-fluid">
            <div class="columns">
                <div class="column user__profile is-3 is-12-touch background-color-secondary">
                    <div class="columns mg-t1">
                        <div class="column user__profile__top">
                            <div class="user__profile__top__img"
                                 style="background: url('https://via.placeholder.com/150') no-repeat center center"></div>
                        </div>
                    </div>
                    <div class="columns is-vcentered is-flex">
                        <div class="user__right column">
                            <div class="level is-mobile user__profile__username">
                                <a class="has-text-white full-w has-text-centered is-size-4"
                                   :href="/user/ + user.username">
                                    <strong>{{ user.name }}</strong>
                                </a>
                            </div>
                            <div class="level has-text-centered">
                                <p class="full-w has-text-center">@{{ user.username }}</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="columns">
                        <div class="column">
                            <div class="level">
                                <span>Tweets</span>
                                <span>{{ user.countPosts }}</span>
                            </div>
                            <div class="level">
                                <span>Abonnements</span>
                                <span>{{ user.countFollowings }}</span>
                            </div>
                            <div class="level">
                                <span>Abonnés</span>
                                <span>{{ user.countFollowers }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-6 is-12-touch posts__center">
                    <div class="columns">
                        <div class="column">
                            <div class="level">
                                <div class="level-left">
                                    <h1 class="color-secondary is-size-4 has-text-white">Latests tweets</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="user.posts.length > 0" class="columns">
                        <div class="column">
                            <div v-for="post in user.posts" class="posts__post mg-t1 has-background-white columns is-flex">
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
                </div>
            </div>
        </div>
    </main>
</template>

<script>
	export default {
		name: "UserComponent",
		data() {
			return {
				user: {
					posts: ''
				}
            }
		},
		methods: {
			getUser(username) {
				axios.get(`/api/test/${username}`)
					.then((response) => this.user = response.data)
					.catch((error) =>  {
						if (500 == error.response.status) window.location.href = '/'
                    })
			}
		},
		beforeMount() {
			let url = window.location.href.split('/');
			let username = url.slice(url.length-1);
			this.getUser(username);
		}
	}
</script>