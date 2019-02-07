<template>
    <main id="content" class="user posts background-color-primary has-text-white">
        <div class="container is-fluid">
            <div class="columns is-multiline">
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
                                <a class="has-text-white" :href=" `/user/${user.username}` ">Tweets</a>
                                <span>{{ user.countPosts }}</span>
                            </div>
                            <div class="level">
                                <a class="has-text-white" :href=" `/user/${user.username}/followings` ">Followings</a>
                                <span>{{ user.countFollowings }}</span>
                            </div>
                            <div class="level">
                                <a class="has-text-white" :href=" `/user/${user.username}/followers` ">Followers</a>
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
                                    <h1 class="color-secondary is-size-4 has-text-white">Followings</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="followings.length > 0" class="columns is-multiline">
                        <div v-for="following in followings" class="column is-12">
                            <div class="posts__post mg-t1 has-background-white columns is-flex">
                                <div class="column posts__post__left">
                                    <a :href="/user/ + following.username">
                                        <div class="posts__post__left__img"
                                             style="background: url('https://via.placeholder.com/150') no-repeat center center"></div>
                                    </a>
                                </div>

                                <div class="column posts__post__right">
                                    <div class="level is-mobile posts__post__right__top has-text-left">
                                        <div class="level-left">
                                            <a :href="/user/ + following.username">
                                                <strong class="posts__post__right__name">{{ following.name }}</strong>
                                            </a>
                                            <span class="posts__post__right__username">@{{ following.username }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        No Followings
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
	export default {
		name: "FollowingComponent",
		data() {
			return {
				user: '',
				followings: ''
            }
		},
		methods: {
			getUser(username) {
				axios.get(`/api/userc/${username}`)
					.then((response) => this.user = response.data)
					.catch((error) =>  {
						if (500 == error.response.status) window.location.href = '/'
                    })
			},
            getFollowings(username) {
				axios.get(`/api/user/followings/${username}`)
                    .then((response) => this.followings = response.data)
                    .catch((error) => {
	                    if (500 == error.response.status) window.location.href = '/'
                    })
            }
		},
		beforeMount() {
			let url = window.location.href.split('/');
			let username = url.slice(4, 5);
			this.getUser(username);
			this.getFollowings(username);
		}
	}
</script>