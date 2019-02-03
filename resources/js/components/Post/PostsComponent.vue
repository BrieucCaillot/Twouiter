<template>
    <main id="content" class="posts background-color-primary">
        <div class="container">
            <div class="columns is-multiline">
                <div class="column is-3 is-12-touch">
                    <div class="columns posts__user background-color-secondary">
                        <div class="column posts__user__left">
                            <div class="posts__user__left__img"
                                 style="background: url('https://via.placeholder.com/150') no-repeat center center"></div>
                        </div>
                        <div class="column posts__user__right has-text-white">
                            <div class="level posts__user__right__top">
                                <strong class="has-text-white">{{ user.name }}</strong>
                            </div>
                            <div class="level">
                                <p>@{{ user.username }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-6 is-12-touch posts__center has-text-white">
                    <div class="posts__newpost columns background-color-secondary">
                        <div class="column">
                            <form @submit.prevent="newTweet()" method="POST">
                                <div class="level">
                                    <h1 class="is-size-4">Quoi de neuf ?</h1>
                                </div>
                                <div class="level">
                                    <input class="input" type="text" v-model="message" placeholder="Quoi de neuf ?">
                                </div>
                                <div class="level">
                                    <button class="button background-color-primary has-text-white" type="submit">Tweeter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div v-for="post in posts" class="posts__post mg-t1 has-background-white columns">
                                <div class="column posts__post__left">
                                    <div class="posts__post__left__img"
                                         style="background: url('https://via.placeholder.com/150') no-repeat center center"></div>
                                </div>
                                <div class="column posts__post__right">
                                    <div class="level posts__post__right__top has-text-left">
                                        <div class="level-left">
                                            <strong class="posts__post__right__name">{{ post.user.name }}</strong>
                                            <span class="posts__post__right__username">@{{ post.user.username }}</span>
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
				posts: '',
                user : ''
			}
		},
		methods: {
			getPosts() {
				axios.get('/api/posts')
					.then((response) => {
						console.log(response);
						this.posts = response.data.data
					})
					.catch((error) => console.log(error))
			},
            getUser() {
	            axios.get('/api/user')
		            .then((response) => {
			            console.log(response);
			            this.user = response.data
		            })
		            .catch((error) => console.log(error))
            },
			newTweet() {
				if (this.message.length > 0) {
					axios.post('/post', {
						message: this.message
					})
						.then((response) => {
							console.log(response)
							if (response.status == 200) this.getPosts();
						})
						.catch((error) => {
							console.log(error);
							return;
							this.errors.username = error.response.data.errors.username
							this.errors.password = error.response.data.errors.password
						})
				}
			}
		},
		beforeMount() {
			document.querySelector('.navbar').classList.add('background-color-secondary')
			this.getUser()
			this.getPosts()
		}
	}
</script>

<style scoped>

</style>