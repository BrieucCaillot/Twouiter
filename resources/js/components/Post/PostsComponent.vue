<template>
    <main id="content" class="posts background-color-primary">
        <div class="container is-fluid">
            <div class="columns is-multiline">
                <div class="column is-3 is-12-touch">
                    <div class="columns is-vcentered posts__user is-flex background-color-secondary">
                        <div class="posts__user__left column ">
                            <div class="posts__user__left__img"
                                 style="background: url('https://via.placeholder.com/150') no-repeat center center"></div>
                        </div>
                        <div class="posts__user__right column has-text-white">
                            <div class="level posts__user__right__top">
                                <a :href="/user/ + user.username"><strong class="is-size-5 has-text-white">{{ user.name }}</strong></a>
                            </div>
                            <div class="level">
                                <p>@{{ user.username }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="columns posts__user background-color-secondary has-text-white mg-t2">
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
                    <div class="posts__newpost columns background-color-secondary has-text-white">
                        <div class="column">
                            <form @submit.prevent="newTweet()" method="POST">
                                <div class="level">
                                    <h1 class="is-size-4">Quoi de neuf ?</h1>
                                </div>
                                <div class="level">
                                    <textarea class="textarea" rows="2" type="text" v-model="message" placeholder="Whats up ?"></textarea>
                                </div>
                                <div class="level">
                                    <button class="button background-color-primary has-text-white" type="submit">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div v-if="user.posts.length > 0" class="columns">
                        <div class="column">
                            <div v-for="post in allPosts" class="posts__post mg-t1 has-background-white columns is-flex">
                                <div class="column posts__post__left">
                                    <a :href="/user/ + post.user.username">
                                    <div class="posts__post__left__img"
                                         style="background: url('https://via.placeholder.com/150') no-repeat center center"></div>
                                    </a>
                                </div>
                                <div class="column posts__post__right">
                                    <div class="level is-mobile posts__post__right__top has-text-left">
                                        <div class="level-left">
                                            <a :href="/user/ + post.user.username">
                                                <strong class="posts__post__right__name">{{ post.user.name }}</strong>
                                            </a>
                                            <span class="posts__post__right__username">@{{ post.user.username }}</span>
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
		name: "Posts",
		data() {
			return {
				message: '',
				user: {
					posts: '',
					countPosts: ''
                },
				allPosts: ''
			}
		},
		methods: {
			getPosts() {
				axios.get('/api/allposts')
					.then((response) => this.allPosts = response.data.data)
					.catch((error) => console.log(error))
			},
			getUser() {
				axios.get('/api/userc')
					.then((response) => this.user = response.data)
					.catch((error) => console.log(error))
			},
			newTweet() {
				if (this.message.length > 0) {
					axios.post('/post', {
						message: this.message
					})
						.then((response) => {
							if (response.status == 200) {
								this.getPosts();
								this.user.countPosts++
                            };
						})
						.catch((error) => {
							console.log(error);
						})
				}
			}
		},
		beforeMount() {
			this.getUser()
			this.getPosts()
		}
	}
</script>

<style scoped>

</style>